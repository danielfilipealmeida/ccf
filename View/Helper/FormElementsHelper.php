<?php
class FormElementsHelper extends AppHelper {
    public $helpers = array('Html', 'Form', 'Js');
    
    
    /* Javascript function templates */
    public $JSFunc_drawModelCell = "function drawModelCell(data, mode) {
                    mode = typeof mode !== 'undefined' ? mode : 'remove';
                    
                    if (mode == 'remove') button_class = 'removebutton';
                    else button_class='addbutton';
                    //console.log(data);
                    var html='';
                    var ref = data.code;
                    var stagename = data.stagename;
                    var id = data.ID;
                    var modelThumbUrl = '/pornModels/thumbnail/'+ref;
                    var modelLink = '/pornModels/view/'+id;
                    html+='<div class=\"modelcell\">';
                    html+='    <img src=\"'+modelThumbUrl+'\" width=\"80\" height=\"120\">';
                    html+='     <p class=\"title\"><a href=\"'+modelLink+'\">'+ref+' - '+stagename+'</a></p>';
                    html+='      <button type=\"button\" class=\"'+button_class+'\" modelid=\"'+id+'\">'+mode+'</button>';
                    html+='</div>';
                    return html;
                }";
    
    public $JSFunc_drawModelCells = "function drawModelCells() {
                    // get the data
                    
                    var data = $('#modelsJson').val();
                    if (data=='') {
                        $('#models_interface').html('No Models!');
                        return;
                    }
                    var json = jQuery.parseJSON(data);
                    var html='';
                  
                    var c = 0;
                    $.each(json,function(index,value) {
                        html+=drawModelCell(value, 'remove');
                        c++;
                    });
                    if (c==0) html='No Models!';
                    html+='<br class=\"clearFloats\" />';
                    $('#models_interface').html(html);
                   
                    $('.removebutton').on('click', function(event) {
                        var id = $(this).attr('modelid');
                        removeModel(id);
                    });
                }";
    
    
    public $JSFunc_updateJSON="function updateJSON() {
                    // get the id's
                    var ids = $('#modelsIds').val();
                    
                    if (ids=='') {
                        $('#modelsJson').val('');
                        drawModelCells();
                        return;
                    }
                    
                    // get all data and update
                    var call_url = '/pornModels/ajax_getModelsData/'+ids;
                    //console.log(ajax_url);
                    
                    $.getJSON(call_url, function(data) {
                        //console.log(data);
                        var pornModelData = new Array();
                        $.each(data,function(index,value) {
                            //console.log(value.PornModel);
                            pornModelData.push(value.PornModel);
                        });
                        
                        var pornDataString = JSON.stringify(pornModelData);
                        console.log(pornDataString);
                        $('#modelsJson').val(pornDataString);
                        drawModelCells();
                    });
                }";
 
    public function drawCheckboxIcon($value = 0) {
        if ($value == 0) return($this->Html->image('icon_unchecked.png'));
        else return($this->Html->image('icon_checked.png'));
    }

    public function timer($value) {
        $result = "";
        //$result = $value."-";
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
        if ($value>3600) {
            $hours = floor($value/3600);
            $value = $value%3600;
        }
        if ($value>60) {
            $minutes = floor($value/60);
            $value = $value%60;
        }
        $seconds = $value;
        
        $result = $result.str_pad($hours,2,"0",STR_PAD_LEFT).":".str_pad($minutes,2,"0",STR_PAD_LEFT).":".str_pad($seconds,2,"0",STR_PAD_LEFT);
        return $result;
    }

    /*
     * 
     * $button_class:
     *      - removebutton, addbutton
     * $mode
     *      - remove, add
     * 
     */
    function getModelCell($modelData, $button_class='', $mode='add') {
        //debug ($modelData);
        
        $ref = $modelData['code'];
        $id = $modelData['ID'];
        $stagename = $modelData['stagename'];
        $modelThumbUrl = "/pornModels/thumbnail/".$ref;
        $modelLink = "/pornModels/view/".$id;
        
        $html='<div class="modelcell">';
        $html.='    <img src="'.$modelThumbUrl.'" width="80" height="120">';
        $html.='     <p class="title"><a href="'.$modelLink.'">'.$ref.' - '.$stagename.'</a></p>';
        if (!isset($modelData['selected'])) $html.='      <button type="button" class="'.$button_class.'" modelid="'.$id.'">'.$mode.'</button>';
        else {
            $checked = '';
            if ($modelData['selected']==1)$checked = "checked";
            $html.='<input type="checkbox" modelid="'.$id.'" name="selectedModel_'.$id.'" '.$checked.'> Selected';
        }
        $html.='</div>';
        
        return $html;
    }
    
    function drawModelSelection($modelsID, $modelsArray) {
       
        echo $this->Form->input('models.display',array( 'label'=>'Models', 'after'=>'Start typing stagename or reference to get models.'));
       
        //<div class='input'>
        
        ?>
            <div id='models_interface_add' style="display:none"></div>
        <?php
        //         </div>

        echo $this->Form->hidden('models.ids',array('value'=>$modelsID));
        echo $this->Form->hidden('models.json',array('value'=>  json_encode($modelsArray)));
        ?>
        <h4>Selected Models</h4>
        <div id='models_interface'>No models</div>
        <?php
        /* jquery script to handle the models interface */
        $this->Html->scriptBlock(implode("\n",array(
            $this->JSFunc_drawModelCell,
            $this->JSFunc_drawModelCells,
            $this->JSFunc_updateJSON))
        ."    
              
                function removeModel(id) {
                    
                    // update Ids
                    var ids = $('#modelsIds').val();
                    idsArray = ids.split(',');
                    idsArray.splice(idsArray.indexOf(id), 1);
                    
                    var newIds = idsArray.join(',');
                    
                    $('#modelsIds').val(newIds);
                    updateJSON();
                    return;
                    
                }
                function addModel(id) {
                    var ids = $('#modelsIds').val();
                    idsArray = ids.split(',');
                    
                    // check if the id isn't on the array and only add if not
                    if (idsArray.indexOf(id)<0) {
                        idsArray.push(id);
                        var newIds = idsArray.join(',');
                        $('#modelsIds').val(newIds);
                    }
                    updateJSON();
                    
                }

                function getModels() {
                    var input = $('#modelsDisplay').val();
                    
                    if (input.length>2) {
                        $('#models_interface_add').html('<img src=\"/img/ajax-loader.gif\" />');
                        $('#models_interface_add').show();
                        
                        var call_url = '/pornModels/ajax_searchModel/'+input;
                        
                        $.getJSON(call_url, function(data) {
                            html = '';
                            var c = 0;
                            $.each(data, function(index,value) {
                                //console.log(value);
                                var cellData = new Object();
                                cellData.ID = value.PornModel.ID;
                                cellData.code = value.PornModel.code;
                                cellData.stagename = value.PornModel.stagename;
                                //console.log(value.PornModel.code);
                                html+=drawModelCell(cellData, 'add');
                                c++;
                            });
                            if (c==0) html='No Models found!';
                            html+='<br class=\"clearFloats\" />';
                            $('#models_interface_add').html(html);
                            $('#models_interface_add').show();
                            $('.addbutton').on('click', function(event) {
                                var id = $(this).attr('modelid');
                                addModel(id);
                            });
                        });
                    } else {
                        $('#models_interface_add').hide();
                    }
                }
               ",
            array('inline' => false)
        );
        $this->Js->get('document')->event('ready',"drawModelCells();");
        $this->Js->get('#modelsDisplay')->event('click', "drawModelCells();");
        $this->Js->get('#modelsDisplay')->event('keyup', "getModels();");
    }
    
    
    
    
     public function drawModelSelectionInVideoitemPage($videoitemID, $videosetID) {
        echo $this->Form->input('models.display',array( 'label'=>'Add Model not it Videoset', 'after'=>'Start typing a stagename or reference to get new models not in this Videoset.'));
        echo("<div class='input'><div id='models_interface_add' style='display:none'></div></div>");
        echo $this->Form->input('models.ids');
        echo $this->Form->hidden('models.json');
        $this->Html->scriptBlock(implode("\n", array(
            $this->JSFunc_drawModelCell,
            $this->JSFunc_updateJSON))
                ." 
              function drawModelCells() {
                    $('#models_interface_add').hide();
                }


                function addModel(id) {
                    var ids = $('#modelsIds').val();
                    idsArray = ids.split(',');
                    
                    // check if the id isn't on the array and only add if not
                    if (idsArray.indexOf(id)<0) {
                        idsArray.push(id);
                        var newIds = idsArray.join(',');
                        $('#modelsIds').val(newIds);
                    }
                    updateJSON();
                    
                }
                

                function getModels() {
                    var input = $('#modelsDisplay').val();
                    var videosetID =  $('#VideoItemVideosetID').val();
                    
                    if (input.length>2) {
                        $('#models_interface_add').html('<img src=\"/img/ajax-loader.gif\" />');
                        $('#models_interface_add').show();
                        
                        var call_url = '/pornModels/ajax_searchModelNotInSet/'+input+'/'+videosetID;
                        console.log(call_url);
                        $.getJSON(call_url, function(data) {
                            html = '';
                            var c = 0;
                            $.each(data, function(index,value) {
                                //console.log(value);
                                var cellData = new Object();
                                cellData.ID = value.PornModel.ID;
                                cellData.code = value.PornModel.code;
                                cellData.stagename = value.PornModel.stagename;
                                //console.log(value.PornModel.code);
                                html+=drawModelCell(cellData, 'add');
                                c++;
                            });
                            if (c==0) html='No Models found!';
                            html+='<br class=\"clearFloats\" />';
                            $('#models_interface_add').html(html);
                            $('#models_interface_add').show();
                            $('.addbutton').on('click', function(event) {
                                var id = $(this).attr('modelid');
                                addModel(id);
                            });
                        });
                    } else {
                        $('#models_interface_add').hide();
                    }
                }
               ",
            array('inline' => false)
        );
        $this->Js->get('#modelsDisplay')->event('keyup', "getModels();"); 
        
    }
    
    
    function drawVideosetSelector($videoset_id) {
        echo $this->Form->input('videoset_id', array('type' => 'hidden'));
         echo $this->Form->input('videoset.display',array( 'label'=>'Videoset', 'after'=>'Start typing a videoset name or reference to get data.'));
       
        ?>
        <div id='videoset_interface_add' style="display:none"></div>       
        <div id='videoset_interface'>No Videoset</div>
       <?php
       
        /* jquery script to handle the videoset chooser interface */
        $this->Html->scriptBlock("   
            var xhr;
            
            function drawVideosetCell(data, mode) {
                    mode = typeof mode !== 'undefined' ? mode : 'remove';
                    
                    if (mode == 'remove') button_class = 'removebutton';
                    else button_class='addbutton';
                    
                //console.log(data.Videoset);
                var html;
                var videosetLink = '/Videosets/edit/'+data.Videoset.ID;
                var videosetThumb = '/Videosets/thumbnail/'+data.Videoset.ID;
                //console.log(videosetThumb);
                html='<div class=\"videosetCell\">';
                html+='<img src=\"'+videosetThumb+'\"><br /><p class=\"title\"><a href=\"'+videosetLink+'\">'+data.Videoset.ref+' - '+data.Videoset.title+'</img></a></p>';
                html+='      <button type=\"button\" class=\"'+button_class+'\" videosetid=\"'+data.Videoset.ID+'\">'+mode+'</button>';
                html+='</div>';
                return html;        
            }
            
            function setVideoset(id) {
                $(\"#PhotoVideosetId\").val(id);
                showCurrentSelectedVideoset();
            }
            

            function showCurrentSelectedVideoset() {
                // get the id
                var videosetid = $(\"#PhotoVideosetId\").val();
                
                if (typeof videosetid === \"undefined\" || videosetid==0) return;


                // get the data
                var url;
                call_url = \"/Videosets/ajax_getVideoset/\"+videosetid;
                //console.log(call_url);
                
                // get the html for the cell
                //var html = \"/Videosets/ajax_getVideoset/\"+videosetid;
                $.getJSON(call_url, function(data) {
                    //console.log(data);
                    var html = drawVideosetCell(data, 'remove');
                    $(\"#videoset_interface\").html(html+'<br style=\"clear:left\">');
                    
                     $('.removebutton').on('click', function(event) {
                        var id = $(this).attr('videosetid');
                        console.log(id);
                        $(\"#PhotoVideosetId\").val(\"\");
                        $(\"#videoset_interface\").html(\"No Videoset\");
                        //removeModel(id);
                    });
                });
                
            }
            

            function getVideosets() {
                var input = $('#videosetDisplay').val();
                    
                $('#videoset_interface_add').html('<img src=\"/img/ajax-loader.gif\" />');
                $('#videoset_interface_add').show();
                
                if (input.length>2) {
                    var call_url = '/Videosets/ajax_searchVideoset/'+input;
                    //console.log(call_url);  
                    console.log(xhr);
                    if (typeof xhr !== \"undefined\") xhr.abort();
                    xhr = $.getJSON(call_url, function(data) {
                        //console.log(data);
                        html = '';
                        var c=0;
                         $.each(data, function(index,value) {
                            //console.log(value);
                            //cellData.stagename = value.PornModel.stagename;
                            html+=drawVideosetCell(value, 'add');
                            c++;
                        });
                           
                        if (c==0) html='No Models found!';
                        html+='<br class=\"clearFloats\" />';
                        $('#videoset_interface_add').html(html);
                        $('#videoset_interface_add').show();
                        
                        $('.addbutton').on('click', function(event) {
                            var id = $(this).attr('videosetid');
                            //console.log(id);
                            setVideoset(id);
                        });
                            
                    });
                }
            }
            

        ",
            array('inline' => false));
        $this->Js->get('document')->event('ready',"showCurrentSelectedVideoset();");
        $this->Js->get('#videosetDisplay')->event('keyup', "getVideosets();");
    }
    
    
    
    
    function drawPhotosetSelector($photoset_id) {
        echo $this->Form->input('photoset_id', array('type' => 'hidden'));
         echo $this->Form->input('photoset.display',array( 'label'=>'Photoset', 'after'=>'Start typing a photoset name or reference to get data.'));
       
        ?>
        <div id='photoset_interface_add' style="display:none"></div>       
        <div id='photoset_interface'>No Photoset</div>
       <?php
       
        /* jquery script to handle the videoset chooser interface */
        $this->Html->scriptBlock("   
            var xhr;
            
            function drawPhotosetCell(data, mode) {
                    mode = typeof mode !== 'undefined' ? mode : 'remove';
                    
                    if (mode == 'remove') button_class = 'removebutton';
                    else button_class='addbutton';
                    
                //console.log(data);
                var html;
                var photosetLink = '/Photos/edit/'+data.Photo.ID;
                var photosetThumb = '/Photos/thumbnail/'+data.Photo.ref;
                //console.log(photosetThumb);
                html='<div class=\"photosetCell\">';
                html+='<img src=\"'+photosetThumb+'\"><br /><p class=\"title\"><a href=\"'+photosetLink+'\">'+data.Photo.ref+' - '+data.Photo.title+'</img></a></p>';
                html+='      <button type=\"button\" class=\"'+button_class+'\" photosetid=\"'+data.Photo.ID+'\">'+mode+'</button>';
                html+='</div>';
                return html;        
            }
            
            function setPhotoset(id) {
            
                if($(\"#VideoItemPhotosetId\").length > 0 ) $(\"#VideoItemPhotosetId\").val(id);
                else if($(\"#VideosetPhotosetId\").length > 0 ) $(\"#VideosetPhotosetId\").val(id);
                
                //$(\"#VideosetPhotosetId\").val(id);
                //console.log(id);
                showCurrentSelectedPhotoset();
            }
            
            
            function getPhotosetID() {
                var photosetid = -1;
                if($(\"#VideoItemPhotosetId\").length > 0 ) photosetid=$(\"#VideoItemPhotosetId\").val();
                else if($(\"#VideosetPhotosetId\").length > 0 ) photosetid=$(\"#VideosetPhotosetId\").val();
                //if(typeof $(\"#VideoItemPhotosetId\").length!='undefined') photosetid=$(\"#VideosetPhotosetId\").val();
                //else if(typeof $(\"#VideoItemPhotosetId\").length!='undefined') photosetid=$(\"#VideoItemPhotosetId\").val();
                return photosetid;
            }


            function showCurrentSelectedPhotoset() {
                // get the id
                var photosetid = getPhotosetID();
                console.log(photosetid);
                if (typeof photosetid === \"undefined\" || photosetid==0) return;
                
                // get the data
                var url;
                call_url = \"/Photos/ajax_getPhotoset/\"+photosetid;
                //console.log(call_url);
                
                // get the html for the cell
                //var html = \"/Photos/ajax_getPhotoset/\"+photosetid;
                $.getJSON(call_url, function(data) {
                    //console.log(data);
                    var html = drawPhotosetCell(data, 'remove');
                    html=html+ '<br clear=\"left\" />';
                    $(\"#photoset_interface\").html(html);
                    
                     $('.removebutton').on('click', function(event) {
                        var id = $(this).attr('photosetid');
                        console.log(id);
                        //$(\"#VideosetPhotosetId\").val(\"\");
                        
                        if($(\"#VideoItemPhotosetId\").length > 0 ) $(\"#VideoItemPhotosetId\").val(\"\");
                        else if($(\"#VideosetPhotosetId\").length > 0 ) $(\"#VideosetPhotosetId\").val(\"\");
                

                        $(\"#photoset_interface\").html(\"No Photoset\");
                        //removeModel(id);
                    });
                });
                
            }
            

            function getPhotosets() {
                var input = $('#photosetDisplay').val();
                    
                $('#photoset_interface_add').html('<img src=\"/img/ajax-loader.gif\" />');
                $('#photoset_interface_add').show();
                
                if (input.length>2) {
                    var call_url = '/Photos/ajax_searchPhotoset/'+input;
                    //console.log(call_url);  
                    console.log(xhr);
                    if (typeof xhr !== \"undefined\") xhr.abort();
                    xhr = $.getJSON(call_url, function(data) {
                        //console.log(data);
                        html = '';
                        var c=0;
                         $.each(data, function(index,value) {
                            html+=drawPhotosetCell(value, 'add');
                            c++;
                        });
                           
                        if (c==0) html='No Photosets found!';
                        html+='<br class=\"clearFloats\" />';
                        $('#photoset_interface_add').html(html);
                        $('#photoset_interface_add').show();
                        
                        $('.addbutton').on('click', function(event) {
                            
                            var id = $(this).attr('photosetid');
                            //console.log(id);
                            setPhotoset(id);
                        });
                            
                    });
                }
            }
            

        ",
            array('inline' => false));
        $this->Js->get('document')->event('ready',"showCurrentSelectedPhotoset();");
        $this->Js->get('#photosetDisplay')->event('keyup', "getPhotosets();");
    }
    
    
    
    
    

     public function drawPhotosetThumbnailsList($id, $ref, $thumbnailsInfo) {
         ?>
         <div id="thumbnails_interface">
        <?php
        $count = 0;
        if (!empty($thumbnailsInfo) or isset($thumbnailsInfo)) {
            foreach($thumbnailsInfo as $thumb) {
                if ($thumb['file_exist']) {
                    $count++;
            ?>
            <div class='photoGalleryCell'>
                <div class='imageCellContainerDiv'>
                    <img src='<?=$thumb['file_getter'];?>' />
                    <span class='imageCellHoverDiv'><?=$thumb['image_dimensions'];?></span>
                </div>
                <div class='info'>
                    filesize: <?=$thumb['image_size'];?> kB<br />
                    permissions: <?=$thumb['permissions'];?><br />
                    owner: <?=$thumb['owner']['name'];?> (gid:<?=$thumb['owner']['gid'];?>)<br />
                </div>
            </div>
            <?php
                }
            }
        }
        if ($count == 0) echo("No Thumbnail set. Please go to the Photoset Gallery and set a Thumbnail.");
        
        ?>
                <br style="clear:both" />
            </div>
       <?php
     }
     
     
     
    public function drawPhotosetThumbnails($id, $ref, $thumbnailsInfo) {
        //debug($thumbnailsInfo);
         //foreach($thumbnailsInfo as $thumb)
        ?>
        <div class='input'>
            <label>Thumbnails</label>
            <?php  $this->drawPhotosetThumbnailsList($id, $ref, $thumbnailsInfo);?>
        </div>
        <?php
    }
    
    
    
    
    /* Index Images Funcitons */
    
    public function drawIndexImagesList($id, $ref, $indexImagesInfo) {
        ?>
        <div id="indeximages_interface">
                <?php
                if ($indexImagesInfo['error']) echo("ERROR: ". $indexImagesInfo['message']);
                else {
                    if (isset($indexImagesInfo['data'])){
                        foreach($indexImagesInfo['data'] as $indeximage) {
                            //debug($indeximage);
                            ?>
                            <div class='photoGalleryCell'>
                               <div class='imageCellContainerDiv'>
                                   <img src='<?=$indeximage['image_path'];?>' />
                               </div>
                               <div class='info'>
                                   filesize: <?=$indeximage['image_size'];?> kB<br />
                                   permissions: <?=$indeximage['permissions'];?><br />
                                   owner: <?=$indeximage['owner']['name'];?> (gid:<?=$indeximage['owner']['gid'];?>)<br />
                               </div>
                           </div>
                            <?php
                        }
                    } else {
                        echo("Indeximages not set yet. Please upload or set on the gallery.");
                    }
                }
            ?>
                
                <br style="clear:both" />
        </div>
             <?php 
    }
    
    
    public function drawIndexImages($id, $ref, $indexImagesInfo) {
        //debug($indexImagesInfo);
        ?>
        <div class='input'>
            <label>Index Images</label>
            <?php $this->drawIndexImagesList($id, $ref, $indexImagesInfo); ?>
            
        </div>
        
       <?php
    }
    

    
    public function drawCategorySelector($mode, $item_id, $categoriesArray, $site_id) {
        $availableModes = array("photoset", "videoset", "videoitem" );
        if (!in_array($mode, $availableModes)) $mode = $availableModes[0];
     
        if ($mode == $availableModes[0]) {
            $ajaxSwitcher="/photos/ajax_switchCategoryForSite";
        }
        if ($mode == $availableModes[1]) {
            $ajaxSwitcher="/videosets/ajax_switchCategoryForSite";
        }
        if ($mode == $availableModes[2]) {
            $ajaxSwitcher="/VideoItems/ajax_switchCategoryForSite";
        }
        
        if ($categoriesArray==null) {
        }
        
        ?>
        <h3>Categories</h3>
        <div id="categories_interface">
            <table cellpadding="0" cellspacing="0" id="categoriesTable">
            <?php
            foreach($categoriesArray as $category) {
               
                if($category['active']) $image = $this->Html->image("icon_checked.png"); else $image = $this->Html->image("icon_unchecked.png");
            
                ?>
                <tr>
                    <td width="70%"><?=$category['name']?></td>
                    <td width="10%" class='categories_interface_image_col'><?=$image?></td>
                    <td width="20%"><a href="javascript:void();" class='categoryChange' item_id='<?=$item_id?>' category_id='<?=$category['ID']?>'>Change</a></td>
                </tr>
                <?php
            }
            ?>
            </table>
        </div>
        <?php
        
        // code to handle
        $this->Html->scriptBlock("   
            var categoriesArray = ".json_encode($categoriesArray).";
            
            function changeCategory(linkHtml) {
                var item_id = linkHtml.attr('item_id');
                var category_id = linkHtml.attr('category_id');
          
                // change on the categoriesArray.
                for(var f=0; f< categoriesArray.length;f++) {
                    if (categoriesArray[f].ID == category_id) {
                        if (categoriesArray[f].active == true) categoriesArray[f].active=false; // switch value
                        else categoriesArray[f].active=true;
                        var value = categoriesArray[f].active;
                    }
                }
         
                // change on the screen
                var image;
                if (value==true) image = '/img/icon_checked.png';
                else image = '/img/icon_unchecked.png';
                //linkHtml.attr('src', image);
                //console.log(linkHtml.parent().parent().find('.categories_interface_image_col').find('img'));
                linkHtml.parent().parent().find('.categories_interface_image_col').find('img').attr('src', image);
                
                // use json to order the change in the content
                console.log('".$ajaxSwitcher."?id='+item_id+'&category_id='+category_id+'&site_id=".$site_id."');
                $.getJSON('".$ajaxSwitcher."',{id: item_id, category_id: category_id, site_id:".$site_id."}, function(result) {
                    
                });
            }
        ", array('inline' => false));
        $this->Js->get('.categoryChange')->event('click','
            changeCategory($(this));
        ');
    
    }
    
          
    public function drawSiteSelectorForSet($mode, $id, $sitesArray) {
        $allowedModes = array("Photoset", "Videoset");
        if (!in_array($mode, $allowedModes)) $mode = $allowedModes[0];
        
        $modesConfiguration = array(
            'Photoset' => array(
                'ajaxSetterFuntionURL' => '/photos/ajax_schedulePhotosetToSite',
                'ajaxGetterFunctionURL' => '/photos/ajax_getSitesForPhotoset',
                'ajaxRemoverFuntionURL' => '/photos/ajax_removePhotosetFromSite'
            ), 
            'Videoset' => array(
                'ajaxSetterFuntionURL' => '/videosets/ajax_scheduleVideosetToSite',
                'ajaxGetterFunctionURL' => '/videosets/ajax_getSitesForVideoset',
                'ajaxRemoverFuntionURL' => '/videosets/ajax_removeVideosetFromSite'
            )
        )
        ?>
        
        <h3>Sites</h3>
        <div class='formGroup'>
           
            <table cellpadding="0" cellspacing="0" id="sitesTable">
            <tr>
                <th width="40%">Site</th>
                <th width="20%">Release Date</th>
                <th width="10%">Active in Content</th>
                <th width="10%">Active in Site</th>
                <th width="20%">Actions</th>
        </tr>
        <?php foreach($sitesArray as $site) {  
            if($site['activeInContent'])$imageActiveContent = $this->Html->image("icon_checked.png"); else $imageActiveContent = $this->Html->image("icon_unchecked.png");
            if($site['activeInSite'])$imageActiveSite = $this->Html->image("icon_checked.png"); else $imageActiveSite = $this->Html->image("icon_unchecked.png");
            ?>
            <tr>
                    <td><?=$site['siteName']?></td>
                    <td><?=$site['date']?></td>
                    <td><?=$imageActiveContent?></td>
                    <td><?=$imageActiveSite?></td>
                    <td><a href="javascript:void()" class="removeSetFromSite" site_id="<?=$site['siteID']?>" set_id="<?=$id?>">Remove</a></td>
            </tr>
         <? } 
         if (empty($sitesArray)) { ?>
            <tr><td colspan="5">No Site with this Photoset added</td></tr>
         <?php }?> 
            </table>
            
         <?php
         
            echo $this->Form->input('siteSelectorMode', array(
                    'type' => 'hidden',
                     'id' => 'siteSelectorMode',
                     'value' => $mode
                ));
                
          
         
         
            $startDate =date("Y-M-d");
            echo $this->Form->input('sites', array( 
                'options' => array(),
                'label' => 'Site to schedule',
                'id' => 'Sites'
            ));
            echo $this->Form->input('releaseDate', array(
                'type' => 'date', 
                'label' => 
                'Release Date', 
                'default'=>$startDate,
                'minYear' => date('Y') - 5,
                'maxYear' => date('Y') + 2,
                'id' => 'ReleaseDate'
                    ));
            
            if ($mode == $allowedModes[1]) {
                
                echo $this->Form->input('autoaddItems', array(
                    'options' => array(),
                    'type' => 'checkbox',
                    'label' => 'Auto add Items',
                    'id' => 'AutoaddItems',
                    'after' => '&nbsp;&nbsp;<i>(You need to check this to automatically add all the items of this set)</i>'
                ));
                
                echo $this->Form->input('itemsInterval', array(
                    'options' => array(),
                    'type' => 'text',
                    'label' => 'Items Interval',
                    'id' => 'ItemsInterval',
                    'after' => '&nbsp;&nbsp;<i>(examples: 0 is all items on the same day and 7 is a one item weekly)</i>',
                    'class' => 'smallerInput',
                    'value' => '0'
                ));
                
            }
            
            echo $this->Form->button('Add to Site',array('id'=>'updateTabelsButton'));

            
            ?>
        </div>
        <?php
        
            echo $this->Html->scriptBlock("
                var sitesWithSetData = ".json_encode($sitesArray).";


                // nao está a gerar a lista correcta.
                function updateAddToSiteDropdown() {
                   
                    // traverse all the sites and create an array containing all the sites there are no ".strtolower($mode)." on.
                    var sitesWithoutSet = new Array();
                    var count=0;
                    for (var f = 0; f<activeWebsitesData.length; f++) {
                        var siteId = activeWebsitesData[f]['Website']['ID'];

                        // search for this site on the list of the added sites.
                        var found = false;
                        for (g=0;g<sitesWithSetData.length; g++) {
                            if (siteId == sitesWithSetData[g]['siteID']) found=true; 
                        }

                        // if it wasn't found, add it to the list
                        if (!found) {
                            var record = new Array();
                            record['ID'] = siteId;
                            record['name'] = activeWebsitesData[f]['Website']['website'];
                            sitesWithoutSet.push(record);
                            count++;
                        }
                    }

                    // remove all
                    $('#Sites').empty();

                    // add to site
                    for (f=0;f<sitesWithoutSet.length;f++) {
                          $('#Sites').append($('<option>', {
                            value:sitesWithoutSet[f]['ID'],
                            text: sitesWithoutSet[f]['name']
                            }));
                    }
                }



                // this is generating an error : SyntaxError: Unexpected token ')'
                function updateSitesTable() {
                    var html ='';
                    for(var f = 0; f<sitesWithSetData.length;f++ ) {
                        site = sitesWithSetData[f];
                        if (site['activeInContent']) imageActiveContent = 'icon_checked.png'; else imageActiveContent = 'icon_unchecked.png';
                        if (site['activeInSite']) imageActiveSite = 'icon_checked.png'; else imageActiveContent = 'icon_unchecked.png';

                        html=html+'<tr>\\n';
                        html=html+'    <td>'+site['siteName']+'</td>\\n';
                        html=html+'    <td>'+site['date']+'</td>\\n';
                        html=html+'    <td><img src=\"/img/'+imageActiveContent+'\" /></td>\\n';
                        html=html+'    <td><img src=\"/img/'+imageActiveSite+'\" /></td>\\n';
                        html=html+'    <td><a href=\"javascript:void()\" class=\"removeSetFromSite\" set_id=\"".$id."\" site_id=\"'+site['siteID']+'\">Remove</a></td>\\n';
                        html=html+'</tr>\\n';
                    }

                    $('#sitesTable').find('tr:gt(0)').remove();
                    $('#sitesTable').append(html);

                    //$('.removeSetFromSite').off('click');
                    $('.removeSetFromSite').on('click', function() {
                        handleRemoveSetFromSiteLink($(this));
                    });
                }


                function reloadSitesTableData(fn) {
                    //console.log('".$modesConfiguration[$mode]['ajaxGetterFunctionURL']."?set_id=".$id."');
                    $.getJSON('".$modesConfiguration[$mode]['ajaxGetterFunctionURL']."', {set_id:".$id."}, function(data) {
                        sitesWithSetData = data;
                        updateSitesTable(); // <!-- something wierd is happening here!
                        if (typeof fn != 'undefined')  fn();
                    });
                }

                function handleRemoveSetFromSiteLink(element) {

                    var siteName = element.parent().parent().find('td:first').html();
                    var set_id = element.attr('set_id');
                    var site_id = element.attr('site_id');

                    if (confirm('Are you sure you want to remove this Photoset from '+siteName+'?')) {
                        //console.log('".$modesConfiguration[$mode]['ajaxRemoverFuntionURL']."?site_id='+site_id+'&set_id='+set_id);
                        
                        $.getJSON('".$modesConfiguration[$mode]['ajaxRemoverFuntionURL']."', {site_id: site_id, set_id:set_id}, function(data) {
                            console.log(data);
                            reloadSitesTableData(updateAddToSiteDropdown);
                        });
                    }

                }
                ");

            $this->Js->get('#updateTabelsButton')->event('click', '
                
                var site = $("#Sites").find(":selected").val();
                var month = $("#ReleaseDateMonth").find(":selected").val();
                var day = $("#ReleaseDateDay").find(":selected").val();
                var year = $("#ReleaseDateYear").find(":selected").val();
                var date = year+"-"+month+"-"+day;
                var siteSelectorMode = $("#siteSelectorMode").val();
                

                var autoAdd="";
                var interval="";
                
                if (siteSelectorMode=="Videoset") {
                    autoAdd = $("#AutoaddItems").val();
                    interval = $("#ItemsInterval").val();
                }
                //console.log("'.$modesConfiguration[$mode]['ajaxSetterFuntionURL'].'?set_id='.$id.'&site="+site+"&date="+date);
                $.getJSON("'.$modesConfiguration[$mode]['ajaxSetterFuntionURL'].'",{set_id:'.$id.', site: site, date:date, autoAdd: autoAdd, interval: interval}, function(data) {
                    //console.log("'.$modesConfiguration[$mode]['ajaxSetterFuntionURL'].'?set_id='.$id.'");
                    reloadSitesTableData(updateAddToSiteDropdown);
                });

                return false;
                ');

            $this->Js->get('.removeSetFromSite')->event('click', '
                handleRemoveSetFromSiteLink($(this));    
            ');
            $this->Js->get('document')->event('ready', '
                //reloadSitesTableData();
               var siteSelectorMode = "'.$mode.'";
                updateAddToSiteDropdown();
                ');

    }
    
    
    public function drawTagsInput($tags, $tagsArray = null) {
        // get all the tags
        
        echo $this->Form->input('tags.display',array( 'label'=>'Tags', 'after'=>'Start typing the tag.', 'default' => "", 'value'=>$tags));
        ?>
        <div id='tags_interface'>No tags</div>
        <?php
        echo $this->Html->scriptBlock("
                var tagsArray = ".json_encode($tagsArray).";
                   

                function compareStringInArray(string, array) {
                    var result = new Array();
                    for(var f = 0; f<array.length; f++) {
                        if (array[f].search(string)>-1) {
                            result.push(array[f]);
                        }
                    }
                    return (result);
                }
                
                function getUserTagsArray(inputBoxData) {
                    var tagsArray = inputBoxData.split(',');
                    return (tagsArray);
                    //console.log(tagsArray);
                }
                
                function updateAvailableTags(tags) {
                   
                    var html='';
                     for(var f = 0; f<tags.length; f++) {
                        var tag = tags[f];
                        //console.log(tag);
                        html+='<div class=\"tag\">'+tag+'</div>';
                     }
                     html+='<br style=\"clear:both\">';
                     $('#tags_interface').html(html);
                     $('#tags_interface').show();
                     

                     $('#tags_interface .tag').off();
                     $('#tags_interface .tag').on('click', function() {
                        // get the selected tag
                        var tag = $(this).text();
                        
                        // get the 
                        var allTagsString = $('#tagsDisplay').val();
                        var tagsArray = getUserTagsArray(allTagsString);
                        tagsArray.pop();
                        tagsArray.push(tag);
                        $('#tagsDisplay').val(tagsArray.join(',')+',');
                        $('#tags_interface').hide();
                        $('#tagsDisplay').focus();
                        //console.log(tagsArray);
                    });
                }
        ");
        
         $this->Js->get('#tagsDisplay')->event('keyup', '
                var tagsString = $(this).val();
                var userTags = getUserTagsArray(tagsString);
                var lastTag = userTags[userTags.length - 1];
               
                var possibleTags = compareStringInArray(lastTag, tagsArray);
                updateAvailableTags(possibleTags);
                //console.log(possibleTags);
                return true;
             ');
         
         $this->Js->get('#tagsDisplay')->event('click', '
             var string = $(this).val();
             if (string.length>0 && string[string.length-1] != ",") {
                string = string+",";
                $(this).val(string);
            }
        ');
          $this->Js->get('#tagsDisplay')->event('blur', '
             var string = $(this).val();
             if (string[string.length-1] == ",") {
                string = string.substring(0, string.length - 1);
                $(this).val(string);
             }
             ');
         
         //$this->Js->get('document')->event('ready', '');
    }
    
    public function drawFilmSelection($mode, $filmData) {
        //debug($filmData);
        $film_id=0;
        if(isset($filmData['ID'])) $film_id = $filmData['ID'];
        $film_title = "";
        if(isset($filmData['name'])) $film_title = $filmData['ref']." - ".$filmData['name'];
         echo $this->Form->input('film.display',array( 'label'=>'Film', 'after'=>'Start typing the name or reference of the film.', 'default' => $film_title));
        ?>
        
           
            <div id='films_interface_add' style="display:none">
                <select id='films_selector' size="10" style="width:100%"></select>
                <button id='films_selector_addbutton' type='button'>Add Selected Film</button>
            </div>
       
        
        <?php
        echo $this->Form->hidden('film.ids',array('value'=>$film_id));
        echo $this->Form->hidden('film.json',array('value'=>  json_encode($filmData)));
       
        $this->Html->scriptBlock("
            var currentSearchData = new Array();
            var selected_id ;
            var selected_name;
            var current_name;
            
            function getFilms() {
                var filmString = $('#filmDisplay').val();
                
                // hide if this is empty
                if (filmString == '') {
                    $('#films_interface_add').hide();
                    return;
                }
                $.getJSON('/films/ajax_search', {searchString: filmString}, function(data) {
                    
                    // hide if the results are empty
                    if(data.length==0) {
                        $('#films_interface_add').hide();
                        return;
                    }
                    
                    currentSearchData = data;
                    //console.log(data);
                    // clear the selector
                    $('#films_selector').empty();


                    // add data to the selector
                    data.forEach(function(entry) {
                        var film_name = entry.Film.name;
                        var film_ref = entry.Film.ref;
                        var film_id = entry.Film.ID;
                        //console.log(film_name);
                        $('#films_selector').append($('<option>',{ value: film_id, text: film_ref+' - '+film_name}));
                        $('#films_interface_add').show();
                    });
                    
                    
                    $('#films_selector>option').off();
                    $('#films_selector>option').on('click', function() {
                        //console.log($(this));
                        selected_id = $(this).val();
                        selected_name= $(this).text();                 
                    });
                    
                });
            }
            
            function addFilm() {
                // get the id of the selected film
                //var film_id = selected_id;
                //console.log(film_id);
                $('#filmDisplay').val(selected_name);
                $('#filmIds').val(selected_id);
            }
            
            function handleFilmDisplayClick() {
                current_name = $('#filmDisplay').val();
                $('#filmDisplay').val('');
            }
            ",
            array('inline' => false));
        $this->Js->get('document')->event('ready',"");
        $this->Js->get('#filmDisplay')->event('click', "handleFilmDisplayClick();");
        $this->Js->get('#filmDisplay')->event('keyup', "getFilms();");
        $this->Js->get('#films_selector_addbutton')->event('click', "addFilm();");
    }
}
?>    
