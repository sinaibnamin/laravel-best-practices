<?php

namespace App\Http\Controllers;

use App\Models\Instruction;
use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;

class InstructionController extends Controller {

    public function list( Request $request ) {
        $query = Instruction::query();

        if ( $request->member_id != '' ) {
            $query->where( 'member_id',  $request->member_id );
        }

        if ( get_user_role() == 'trainer' ) {
            $trainer_id = Trainer::where( 'phone_number',  get_user_id() )->first()->id;
            $query->where( 'trainer_id',  $trainer_id );
        }else{
            if ( $request->trainer_id != '' ) {
                $query->where( 'trainer_id',  $request->trainer_id );
            }
        }        

        $instructions = $query->orderByDesc( 'created_at' )->paginate( 30 );

        $members = Member::orderBy( 'created_at', 'desc' )->get();
        $trainers = Trainer::orderBy( 'created_at', 'desc' )->get();
       
        return view( 'admin.pages.instruction.list' )
        ->with( 'instructions', $instructions )
        ->with( 'members', $members )
        ->with( 'trainers', $trainers )
        ;
    }

    public function create() {
        $trainer = Trainer::where( 'phone_number',  get_user_id() )->first();
        $members = Member::where('status', '!=', 'Archive')
                 ->orderBy('created_at', 'desc')
                 ->get();

        return view( 'admin.pages.instruction.input' )
        ->with( 'members', $members )
        ->with( 'trainer', $trainer )
        ;
    }

    public function store( Request $request ) {

        if ( $this->app_environment == 'demo' ) {
            return $this->flash_and_back( 'success', 'Instruction set for this member!' );

        }

        $validatedData = $request->validate( [
            'member_id' => 'required|max:255|exists:members,id',
            'description' => 'required|max:2000',
        ] );

        $is_member_active = Member::where( 'id', $request->member_id )->where( 'status', 'Active' )->exists();

        if ( !$is_member_active ) {
            return $this->flash_and_back( 'danger', 'This member is not active!' );
        }

        $instruction = new Instruction;
        $instruction->member_id = $request->member_id;

        $instruction->description = $request->description;

      
        if ( get_user_role() == 'trainer' ) {
            $trainer_id = Trainer::where( 'phone_number',  get_user_id() )->first()->id; $instruction->trainer_id = $trainer_id;
        }


        $instruction->save();

        return $this->flash_and_back( 'success', 'Instruction set for this member!' );

    }

    public function show( Instruction $instruction ) {
        //
    }

    public function edit( $id ) {
        $page_type = 'edit';
        $instruction = Instruction::with( 'member' )->where( 'id', $id )->first();
        $members = Member::orderBy( 'created_at', 'desc' )->get();
        $trainer = Trainer::where( 'phone_number',  get_user_id() )->first();
        return view( 'admin.pages.instruction.input' )
        ->with( 'members', $members )
        ->with( 'instruction', $instruction )
        ->with( 'page_type', $page_type )
        ->with( 'trainer', $trainer );
    }

    public function update( Request $request, $id ) {

        if ( $this->app_environment == 'demo' ) {
            return $this->flash_and_back( 'success', 'Insruction updated' );
        }

        $instruction = Instruction::findOrFail( $id );

        // dd( $instruction->id );

        $validatedData = $request->validate( [
            // 'member_id' => 'required|max:255',
            'description' => 'required|max:2000',
        ] );

        // $instruction->member_id = $request->member_id;

        $instruction->description = $request->description;

        $instruction->save();

        return $this->flash_and_back( 'success', 'Insruction updated' );

    }

    public function delete( $id ) {

        if ( $this->app_environment == 'demo' ) {
            return $this->flash_and_back( 'danger', 'Instruction deleted' );
        }

        $instruction = Instruction::findOrFail( $id );

        $instruction->delete();

        return $this->flash_and_back( 'danger', 'Instruction deleted' );

    }

}
