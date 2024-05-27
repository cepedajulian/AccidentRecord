
tinymce.init({
    selector: "textarea#contenido",
    theme: "modern",
    width: 870,
    theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
    font_size_style_values: "12px,13px,14px,16px,18px,20px",
    height: 400,
    language : 'es',
    relative_urls: false,
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor link image code"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic| fontselect |  fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'},
        {title: 'Imagen Izquierda', selector: 'img', 
            styles: {
                'float' : 'left', 
                        'margin': '15px 20px 10px 0px'
            }
        },
            {title: 'Imagen Derecha', selector: 'img', 
            styles: {
                'float' : 'right', 
                        'margin': '15px 0px 10px 20px'
                }
        },
            {title: 'Imagen Izquierda top', selector: 'img', 
            styles: {
                'float' : 'left', 
               			'margin': '0px 20px 10px 0px'
                }
        },
            {title: 'Imagen Derecha Top', selector: 'img', 
            styles: {
                'float' : 'right', 
                        'margin': '0px 0px 10px 20px'
                }
         }
    ]

 }); 

