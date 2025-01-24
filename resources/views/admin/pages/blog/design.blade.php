<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laravel Newsletter Editor by Khan</title>
    <meta content="Best Free Open Source Responsive No-Code Newsletter HTML Email Builder" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/admin_assets/grapesjs_full_demo/stylesheets/grapes.min.css">
    <link rel="stylesheet" href="/admin_assets/grapesjs_full_demo/stylesheets/material.css">
    <link rel="stylesheet" href="/admin_assets/grapesjs_full_demo/stylesheets/tooltip.css">
    <link rel="stylesheet" href="/admin_assets/grapesjs_full_demo/stylesheets/demos.css">

    <script src="/admin_assets/grapesjs_full_demo/js/grapes.min.js"></script>



    <script src="/admin_assets/grapesjs_full_demo/plugins/web_preset.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />


    <script src="/admin_assets/grapesjs_full_demo/plugins/basic_blocks.js"></script>



</head>
<style>
    .nl-link {
        color: inherit;
    }

    .gjs-logo-version {
        background-color: #5a606d;
    }

    .cke_toolbar.cke_toolbar {
        min-height: 33px;
    }

    .gjs-pn-panel#gjs-pn-views-container,
    .gjs-pn-panel.gjs-pn-views-container {
        height: 100%;
    }

    .gjs-am-file-uploader {
        display: none;
    }

    .gjs-am-assets-cont {
        width: 100%;
    }
</style>

<body>



    <div id="gjs" style="height:0px; overflow:hidden">

    </div>
    <input type="hidden" id="product_id" value="">

    <div id="info-panel" style="display:none">
        <br />
        grapeJS Editor
    </div>

    <div style="display: none">
        <div class="gjs-logo-cont">
            <a href="//grapesjs.com"><img class="gjs-logo"
                    src='/admin_assets/grapesjs_full_demo/img/grapesjs-logo-cl.png'></a>
            <div class="gjs-logo-version"></div>
        </div>
    </div>

    <style>
        .loading-window {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 99;
            background: #000000c9;
        }

        .loading-window h4 {
            color: #ffffff;
            font-size: 25px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>

    <div class="loading-window" style="display: none">
        <h4>please wait.....</h4>
    </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/grapesjs-parser-postcss@1.0.3/dist/index.js"></script>
    <script type="text/javascript">
        var host = '{{ url('/') }}/site_images/uploaded/blog_images/';
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var uploadRoute = 'http://localhost/pagebuilderapp/public/';


        let ast_img_arr_str = '{{ $blog->images }}';

        if (ast_img_arr_str) {
            ast_img_arr_str = ast_img_arr_str.replace(/&quot;/g, '\"');
            ast_img_arr_str = JSON.parse(ast_img_arr_str);
            ast_img_arr_str = ast_img_arr_str.map(item => host + item)
        } else {
            ast_img_arr_str = [];
        }

        // Set up GrapesJS editor with the Newsletter plugin
        var editor = grapesjs.init({
            selectorManager: {
                componentFirst: true
            },
            clearOnRender: true,
            height: '100%',
            storageManager: {
                options: {
                    local: {
                        key: 'gjsProjectNl'
                    }
                }
            },
            storageManager: {
                type: '',
                autoload: 0
            },
            container: '#gjs',
            fromElement: true,
            plugins: ['grapesjs-preset-webpage', 'grapesjs-parser-postcss', 'gjs-blocks-basic', ],
            pluginsOpts: {
                'grapesjs-preset-webpage': {},
                'gjs-blocks-basic': {
                    flexGrid: true
                },
            },
            assetManager: {
                assets: ast_img_arr_str,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },

            },
        });


        // Let's add in this demo the possibility to test our newsletters
        var pnm = editor.Panels;
        var cmdm = editor.Commands;
        var md = editor.Modal;

        const productId = 1;
        // Add save command
        cmdm.add('save-design', {
            run: function(editor, sender) {
                const html = editor.getHtml();
                const css = editor.getCss();
                saveDesign(productId, html, css);
            }
        });




        // Add save button
        const iconStyle2 = 'style="display: block; width: 152px"';
        pnm.addButton('options', [{
            id: 'saveDesign',
            label: `<div style="padding: 0 25px">Save</div>`,
            command: 'save-design',
            attributes: {
                'title': 'Save',
                'data-tooltip-pos': 'bottom',
            },
        }]);




        var titles = document.querySelectorAll('*[title]');
        for (var i = 0; i < titles.length; i++) {
            var el = titles[i];
            var title = el.getAttribute('title');
            title = title ? title.trim() : '';
            if (!title)
                break;
            el.setAttribute('data-tooltip', title);
            el.setAttribute('title', '');
        }

        // Update canvas-clear command
        cmdm.add('canvas-clear', function() {
            if (confirm('Are you sure to clean the canvas?')) {
                editor.runCommand('core:canvas-clear')
                setTimeout(function() {
                    localStorage.clear()
                }, 0)
                displayMessage('Design removed successfully.');
            }
        });

        // Do stuff on load
        editor.onReady(function() {
            // Show borders by default
            pnm.getButton('options', 'sw-visibility').set('active', 1);

            // Show logo with the version
            var logoCont = document.querySelector('.gjs-logo-cont');
            document.querySelector('.gjs-logo-version').innerHTML = 'v' + grapesjs.version;
            var logoPanel = document.querySelector('.gjs-pn-commands');
            logoPanel.appendChild(logoCont);

        });


        function displayMessage(message) {
            toastr.success(message, 'Event');
        }

        function displayErrorMessage(message) {
            toastr.error(message, 'Event');
        }










        editor.on('load', function() {
            editor.setComponents('{!! $blog->blog_html !!}');
            // dfcss = `*{font-family: Arial, Helvetica, sans-serif;}`;
            editor.setStyle('');
            editor.setStyle('{{ $blog->blog_css }}');

        });


        // Function to save the design using AJAX
        function saveDesign(productId, html, css) {

            const loading_window = document.querySelector('.loading-window');
            loading_window.style.display = "block"

            fetch('{{ url('/admin/blog/savedesign') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        // design: design,
                        html: html,
                        css: css,
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // console.log('Design saved successfully', data);
                    displayMessage(data.message);
                    loading_window.style.display = "none"
                })
                .catch(error => {
                    loading_window.style.display = "none"
                    console.error('Error saving design:', error)
                });
        }

        @include('admin.pages.blog.helper_files.blog_design_tools_custom')
    </script>

</body>

</html>
