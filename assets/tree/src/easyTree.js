/**
 * An easy tree view plugin for jQuery and Bootstrap
 * @Copyright yuez.me 2014
 * @Author yuez
 * @Version 0.1
 */
(function ($) {
    $.fn.EasyTree = function (options) {
        var defaults = {
            selectable: true,
            deletable: false,
            editable: false,
            addable: false,
            i18n: {
                deleteNull: 'Select a node to delete',
                deleteConfirmation: 'Delete this node?',
                confirmButtonLabel: 'Okay',
                editNull: 'Select a node to edit',
                editMultiple: 'Only one node can be edited at one time',
                addMultiple: 'Select a node to add a new node',
                collapseTip: 'collapse',
                expandTip: 'expand',
                selectTip: 'select',
                unselectTip: 'unselet',
                editTip: 'edit',
                addTip: 'add',
                deleteTip: 'delete',
                cancelButtonLabel: 'cancle'
            }
        };

       <!-- var warningAlert = $('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong></strong><span class="alert-content"></span> </div> ');-->
       <!-- var dangerAlert = $('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong></strong><span class="alert-content"></span> </div> ');-->

     <!--   var createInput = $('<div class="input-group"><input type="text" class="form-control"><span class="input-group-btn"><button type="button" class="btn btn-default btn-success confirm"></button> </span><span class="input-group-btn"><button type="button" class="btn btn-default cancel"></button> </span> </div> ');-->

        options = $.extend(defaults, options);

        this.each(function () {
            var easyTree = $(this);
            $.each($(easyTree).find('ul > li'), function() { 
                var text;
				
                if($(this).is('li:has(ul)')) {
                    var children = $(this).find(' > ul');
                    $(children).remove();
					var inputfld = $(this).find("input").val();
					
					var inputfldVal = $(this).find("input").attr("id");
					//inputfldVal = trim(inputfldVal);
					 text = $(this).text();
					if(typeof inputfld==='undefined'){
						 //text = text+inputfld;;
						  inputfld ='';
						 
					}                    
					
					var i = $("#panel > :input"); 
					//if(typeof inputfldVal !=='undefined'){
						$(this).html('<span><span class="glyphicon"></span><a href="javascript: void(0);"></a> </span>&nbsp;<em class="treechk">&nbsp; <i class="showusers fa fa-user" onclick="return showUsers('+inputfldVal+')" style="cursor:pointer;" title="Show Users"></i>&nbsp;<i class="group_permit fa fa-gear" onclick="return load_permissions('+inputfldVal+')" title="Set Permissions" style="cursor:pointer;" ></i>&nbsp;<i class="fa fa-pencil-square-o" aria-hidden="true" onclick="return editgroup('+inputfldVal+')" style="cursor:pointer;" title="Edit Group"></i>&nbsp;</em>');
						$(this).find(' > span > span').addClass('glyphicon-folder-open');
						$(this).find(' > span > a').text(text)
						$(this).append(children);
					//}
                }
                else {
					var inputfld = $(this).find("input").val();
					
					var inputfldVal = $(this).find("input").attr("id");
                    text = $(this).text();
                   <!-- $(this).html('<span><span class="glyphicon"></span><a href="javascript: void(0);"></a> </span>&nbsp;<em class="treechk chld"> </em>');-->
				   $(this).html('<span><span class="glyphicon"></span><a href="javascript: void(0);"></a> </span>&nbsp;<em class="treechk">&nbsp; <i class="showusers fa fa-user" onclick="return showUsers('+inputfldVal+')" style="cursor:pointer;" title="Show Users"></i>&nbsp;<i class="group_permit fa fa-gear" onclick="return load_permissions('+inputfldVal+')" title="Set Permissions" style="cursor:pointer;" ></i>&nbsp;<i class="fa fa-pencil-square-o" aria-hidden="true" onclick="return editgroup('+inputfldVal+')" style="cursor:pointer;" title="Edit Group"></i>&nbsp;</em>');
                    $(this).find(' > span > span').addClass('glyphicon-file');
                    $(this).find(' > span > a').text(text) 
                }
            });

            $(easyTree).find('li:has(ul)').addClass('parent_li').find(' > span').attr('title', options.i18n.collapseTip);

             
            // collapse or expand
            $(easyTree).delegate('li.parent_li > span', 'click', function (e) {
                var children = $(this).parent('li.parent_li').find(' > ul > li');
                if (children.is(':visible')) {
                    children.hide('fast');
                    $(this).attr('title', options.i18n.expandTip)
                        .find(' > span.glyphicon')
                        .addClass('glyphicon-folder-close')
                        .removeClass('glyphicon-folder-open');
                } else {
                    children.show('fast');
                    $(this).attr('title', options.i18n.collapseTip)
                        .find(' > span.glyphicon')
                        .addClass('glyphicon-folder-open')
                        .removeClass('glyphicon-folder-close');
                }
                e.stopPropagation();
            });

            // selectable, only single select
            if (options.selectable) {
                $(easyTree).find('li > span > a').attr('title', options.i18n.selectTip);
                $(easyTree).find('li > span > a').click(function (e) {
                    var li = $(this).parent().parent();
                    if (li.hasClass('li_selected')) {
                        $(this).attr('title', options.i18n.selectTip);
                        $(li).removeClass('li_selected');
                    }
                    else {
                        $(easyTree).find('li.li_selected').removeClass('li_selected');
                        $(this).attr('title', options.i18n.unselectTip);
                        $(li).addClass('li_selected');
                    }

                    if (options.deletable || options.editable || options.addable) {
                        var selected = getSelectedItems();
                        if (options.editable) {
                            if (selected.length <= 0 || selected.length > 1)
                                $(easyTree).find('.easy-tree-toolbar .edit > button').addClass('disabled');
                            else
                                $(easyTree).find('.easy-tree-toolbar .edit > button').removeClass('disabled');
                        }

                        if (options.deletable) {
                            if (selected.length <= 0 || selected.length > 1)
                                $(easyTree).find('.easy-tree-toolbar .remove > button').addClass('disabled');
                            else
                                $(easyTree).find('.easy-tree-toolbar .remove > button').removeClass('disabled');
                        }

                    }

                    e.stopPropagation();

                });
            }

            // Get selected items
            var getSelectedItems = function () {
                return $(easyTree).find('li.li_selected');
            };
        });
    };
})(jQuery);

