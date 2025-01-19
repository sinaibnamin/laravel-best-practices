<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Session;

class BlogController extends Controller
{
   
    public function index(Request $request)
    {                 
        $blogs = Blog::all();
        return view('admin.pages.blog.list')->with('blogs', $blogs);
    }
    public function design($id)
    {     
        $blog = Blog::where('id', $id)->first();
        if(!$blog){
            abort(404);
        };    
        return view('admin.pages.blog.design')->with('blog', $blog);
    }

    public function savedesign(Request $request)
    {
        // dd($request->all());
        $productId = $request->product_id;  
        $blog = Blog::find($productId);
       
        if(!$blog){
            return response(['status' => 'ok', 'error' => true, 'message' => 'Something Wrong'], 200);  
        };   

        // check larger 10MB ? 
        // if (mb_strlen($request->html, '8bit') >  1024 * 1024 * 2) {
        //     return response(['status' => 'ok', 'error' => true, 'message' => 'Veery Big Blog'], 200); 
        //   }

        $blog->blog_html = $request->html;      
        $blog->blog_css = $request->css;   

        // dd(mb_strlen($request->html, '8bit'));

        $blog->save();
        return response(['status' => 'ok', 'error' => false, 'message' => 'Successfull Saveed'], 200);  
    }



    public function images($id)
    {     
        $blog = Blog::where('id', $id)->first();
        if(!$blog){
            abort(404);
        };    
        return view('admin.pages.blog.images')->with('blog', $blog);
    }

    public function imagesstore(Request $request,$id)
    {     
        $blog = Blog::where('id', $id)->first();
        if(!$blog){
            abort(404);
        };    



        $files = $request->filepond;


        if($files){

            // dd($files);

            // img validation strat 
            if(count($files) > 30){
                Session::flash('message', 'file quantity limit exceded'); 
                Session::flash('alert-class', 'danger'); 
                Session::flash('icon-class', 'fa-sharp fa-solid fa-xmark'); 
                return redirect()->back();   
            }

            foreach($files as $file){
              
                if(!$file){
                    Session::flash('message', 'Something wrong'); 
                    Session::flash('alert-class', 'danger'); 
                    Session::flash('icon-class', 'fa-sharp fa-solid fa-xmark'); 
                    return redirect()->back();  
                }
                $f_size = mb_strlen($file, '8bit');
                if (mb_strlen($file, '8bit') >  1024 * 1024 * 2) {
                    Session::flash('message', 'file size limit exceded'); 
                    Session::flash('alert-class', 'danger'); 
                    Session::flash('icon-class', 'fa-sharp fa-solid fa-xmark'); 
                    return redirect()->back();  
                }
            }
            // img validation end

            // img upload start 
            $img_arr = [];

            // check for previous img 
            if(json_decode($blog->images)){
                $img_arr = json_decode($blog->images);
            }
          
            foreach($files as $file){
                $fl_array = json_decode($file);
                $file_extnsn = File::extension($fl_array->name);
                $imgname = time().Str::random(30).'.'.$file_extnsn;
                $path = public_path('/site_images/uploaded/blog_images');
                $d_file = base64_decode($fl_array->data);
                file_put_contents($path.'/'.$imgname, $d_file);
                array_push($img_arr,$imgname);
            }

            $blog->images = $img_arr; 
            $blog->save();

        }
      
   
        Session::flash('message', 'Blog image saved'); 
        Session::flash('alert-class', 'success'); 
        Session::flash('icon-class', 'fas fa-check'); 
        return redirect()->back(); 
    }





    public function imagedelete(Request $request, $blogid, $image)
    {
        $blog = Blog::where('id', $blogid)->first();
        if(!$blog){
            abort(404);
        };    

        $blog_html = $blog->blog_html;
       
        if (str_contains($blog_html, $image)) {
            Session::flash('message', 'you cannot delete this image because this image is used on blog, at first delete image from blog'); 
            Session::flash('alert-class', 'warning'); 
            Session::flash('icon-class', 'fa-solid fa-triangle-exclamation'); 
            return redirect()->back(); 
        }

        if (File::exists(public_path("/site_images/uploaded/blog_images/" . $image))) {
            File::delete(public_path("/site_images/uploaded/blog_images/" . $image));
        }

    
        $img_arr = [];
        if(json_decode($blog->images)){
            $img_arr = json_decode($blog->images);
        }
        $img_arr = array_diff($img_arr, array($image));
        $blog->images = $img_arr; 
        $blog->save();




        Session::flash('message', 'Blog image deleted'); 
        Session::flash('alert-class', 'success'); 
        Session::flash('icon-class', 'fas fa-check'); 
        return redirect()->back(); 
    }



    public function trashlist(Request $request)
    {
        $blogs = Blog::select('headline_en', 'id', 'status', 'priority')->orderByDesc('created_at')->get();
        return view('admin.pages.blog.list')->with('blogs', $blogs);
    }

    public function create()
    {
        return view('admin.pages.blog.input');
    }

  

    public function store(Request $request)
    {      
        $blog = Blog::where('id', 1)->first();

        $files = $request->filepond;


        if($files){

            // dd($files);

            // img validation strat 
            if(count($files) > 30){
                Session::flash('message', 'file quantity limit exceded'); 
                Session::flash('alert-class', 'danger'); 
                Session::flash('icon-class', 'fa-sharp fa-solid fa-xmark'); 
                return redirect()->back();   
            }

            foreach($files as $file){
              
                if(!$file){
                    Session::flash('message', 'Something wrong'); 
                    Session::flash('alert-class', 'danger'); 
                    Session::flash('icon-class', 'fa-sharp fa-solid fa-xmark'); 
                    return redirect()->back();  
                }
                $f_size = mb_strlen($file, '8bit');
                if (mb_strlen($file, '8bit') >  1024 * 1024 * 2) {
                    Session::flash('message', 'file size limit exceded'); 
                    Session::flash('alert-class', 'danger'); 
                    Session::flash('icon-class', 'fa-sharp fa-solid fa-xmark'); 
                    return redirect()->back();  
                }
            }
            // img validation end
            
            
            // img upload start 
            $img_arr = [];

            // check for previous img 
            if(json_decode($blog->thumb)){
                $img_arr = json_decode($blog->thumb);
            }
          

            foreach($files as $file){
                $fl_array = json_decode($file);
                $file_extnsn = File::extension($fl_array->name);
                $imgname = time().Str::random(30).'.'.$file_extnsn;
                $path = public_path('/site_images/uploaded/blog_images');
                $d_file = base64_decode($fl_array->data);
                file_put_contents($path.'/'.$imgname, $d_file);
                array_push($img_arr,$imgname);
            }

            $blog->thumb = $img_arr; 
            $blog->save();

        



        }
      
        dd('ok');

        foreach($files as $file){
            $fl_array = json_decode($file);
            $file_extnsn = File::extension($fl_array->name);
            $imgname = time().Str::random(30).'.'.$file_extnsn;
            $path = public_path('/site_images/uploaded/blog_images');
            $d_file = base64_decode($fl_array->data);
            $success = file_put_contents($path.'/'.$imgname, $d_file);
        }

        dd($files);


        dd();
       
        $blog = new Blog;
        $blog->headline_en = $request->headline_en;  
        $blog->slug = Str::slug($request->headline_en, '-');         
        $blog->headline_bn = $request->headline_bn;      
        $blog->summary_en = $request->summary_en;      
        $blog->summary_bn = $request->summary_bn;      
        $blog->blog_category_id = $request->blog_category_id;      
        $blog->blog_source_id = $request->blog_source_id;      
        $blog->link = $request->link;      
        $blog->priority = $request->priority;      
        $blog->time = $request->time;      
        $blog->status = 0;   
        
        if ($request->hasFile('image')) {
            $file = $request->image;
            $imgname = $file->hashName();
            $destinationPath = public_path('/site_images/uploaded/blog_images');
            $file->move($destinationPath, $imgname);
            $blog->image = $imgname;
        }     
       
        $blog->save();

        Session::flash('message', 'Blog created!'); 
        Session::flash('alert-class', 'success'); 
        Session::flash('icon-class', 'fas fa-check'); 
        return redirect()->back();   
       
    }

    public function show($id)
    {       
        $blog = Blog::where('id', $id)->first();
        if(!$blog){
            abort(404);
        };    
        return view('admin.pages.blog.show')->with('blog', $blog);
    }

    public function quickshow($id)
    {       
        $blog = Blog::where('id', $id)->first();
        if(!$blog){
            abort(404);           
        };    
        return view('admin.pages.blog.quickshow')->with('blog', $blog);
    }

    public function print($id)
    {       
        $blog = Blog::where('id', $id)->first();
        $blogs = Cost::orderBy('updated_at')->where('blog_id', $blog->id)->get();
        $calculate_data = [];
        $calculate_data['total_cost'] = Cost::where('blog_id', $blog->id)->sum('cost_amount');      
        return view('admin.pages.blog.print')->with('blog', $blog)->with('costs', $blogs)->with('calculate_data', $calculate_data);
    }

    public function edit($id)
    {
        $page_type = 'edit';
        $blog = Blog::where('id', $id)->first();
        $blog_sources = BlogSource::select('name_en', 'name_bn', 'id')->get();
        $blog_categories = BlogCategory::select('name_en', 'name_bn', 'id')->get();
        return view('admin.pages.blog.input')
        ->with('blog', $blog)
        ->with('blog_categories', $blog_categories)
        ->with('blog_sources', $blog_sources)
        ->with('page_type', $page_type);
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::find($id);

        if(!$blog){
            Session::flash('message', 'Blog not found'); 
            Session::flash('alert-class', 'warning'); 
            Session::flash('icon-class', 'fa-solid fa-triangle-exclamation'); 
            return redirect()->back();   
        };     

  
        $validatedData = $request->validate([           
            'headline_en' => 'required|max:255',
            'headline_bn' => 'required|max:255',
            'summary_en' => 'required|max:500',
            'summary_bn' => 'required|max:500',
            'blog_category_id' => 'required|integer',
            'blog_source_id' => 'required|integer',
            'link' => 'required',
            'priority' => 'required|integer',
            'time' => 'required|min:1|max:20',
        ]);
     

        $blog->headline_en = $request->headline_en;  
        $blog->slug = Str::slug($request->headline_en, '-');       
        $blog->headline_bn = $request->headline_bn;      
        $blog->summary_en = $request->summary_en;      
        $blog->summary_bn = $request->summary_bn;      
        $blog->blog_category_id = $request->blog_category_id;      
        $blog->blog_source_id = $request->blog_source_id;      
        $blog->link = $request->link;      
        $blog->priority = $request->priority;      
        $blog->time = $request->time;      





        if($request->blog_img_edit_status == 'no'){

        }elseif ($request->blog_img_edit_status == 'deleted') {
            if (File::exists(public_path("/site_images/uploaded/blog_images/" . $blog->image))) {
                File::delete(public_path("/site_images/uploaded/blog_images/" . $blog->image));
            }
            $blog->image = null;
        } elseif ($request->blog_img_edit_status == 'changed') {
            
            if ($request->hasFile('image')) {

                if (File::exists(public_path("/site_images/uploaded/blog_images/" . $blog->image))) {
                    File::delete(public_path("/site_images/uploaded/blog_images/" . $blog->image));
                }
    
                $file = $request->image;
                $imgname = $file->hashName();
                $destinationPath = public_path('/site_images/uploaded/blog_images');
                $file->move($destinationPath, $imgname);
                $blog->image = $imgname;
            }    

        }


       
        $blog->save();

        Session::flash('message', 'Blog updated!'); 
        Session::flash('alert-class', 'success'); 
        Session::flash('icon-class', 'fas fa-check'); 
        return redirect()->back();   

    }

    public function close(Request $request, $id)
    {  


// dd($request->all());

        $blog = Blog::find($id); 
        
        if($blog->status == 0){
            Session::flash('message', 'Blog already closed'); 
            Session::flash('alert-class', 'danger'); 
            Session::flash('icon-class', 'fas fa-trash'); 
            return redirect()->back();   
        };
        
        $validatedData = $request->validate([     
            'bill_received' => 'required|numeric',
        ]);     

        $blog->bill_received = $request->bill_received;       
        $blog->status = 0;         

        $blog->save();

        Session::flash('message', 'Blog closed'); 
        Session::flash('alert-class', 'dark'); 
        Session::flash('icon-class', 'fa-solid fa-lock'); 
        return redirect()->back();   
    }



    public function trash($id)
    {
        $blog = Blog::find($id);
        $blog->trash = 1;
        $blog->save();
      
        Session::flash('message', 'Blog moved to trash'); 
        Session::flash('alert-class', 'warning'); 
        Session::flash('icon-class', 'fas fa-trash'); 
        return redirect()->back();         
    }
    public function make_reject($id)
    {
        $blog = Blog::find($id);
        $blog->status = 2;
        $blog->save();
      
        Session::flash('message', 'Blog Rejected'); 
        Session::flash('alert-class', 'dark'); 
        Session::flash('icon-class', 'fa-solid fa-down'); 
        return redirect()->back();         
    }
    public function make_approve($id)
    {
        $blog = Blog::find($id);
        $blog->status = 1;
        $blog->save();
      
        Session::flash('message', 'Blog Approved'); 
        Session::flash('alert-class', 'success'); 
        Session::flash('icon-class', 'fa-solid fa-check'); 
        return redirect()->back();         
    }
    public function make_inactive($id)
    {
        $blog = Blog::find($id);
        $blog->status = 3;
        $blog->save();
      
        Session::flash('message', 'Blog Inactivate'); 
        Session::flash('alert-class', 'warning'); 
        Session::flash('icon-class', 'fa-solid fa-power-off'); 
        return redirect()->back();         
    }







    public function restore($id)
    {
        $blog = Blog::find($id);
        $blog->trash = 0;
        $blog->save();

        Session::flash('message', 'Blog restored'); 
        Session::flash('alert-class', 'success'); 
        Session::flash('icon-class', 'fas fa-check'); 
        return redirect()->back();   
    }

    public function delete($id)
    {
        $blog = Blog::find($id);

        if(!$blog){
            Session::flash('message', 'Blog already deleted or not found'); 
            Session::flash('alert-class', 'danger'); 
            Session::flash('icon-class', 'fa-solid fa-triangle-exclamation'); 
            return redirect()->route('admin.blog.index'); 
        };    


        if (File::exists(public_path("/site_images/uploaded/blog_images/" . $blog->image))) {
            File::delete(public_path("/site_images/uploaded/blog_images/" . $blog->image));
        }

        $blog->delete();

        Session::flash('message', 'Blog permanently deleted!'); 
        Session::flash('alert-class', 'danger'); 
        Session::flash('icon-class', 'fas fa-trash'); 
        return redirect()->route('admin.blog.index'); 
    }

}
