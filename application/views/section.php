<?php defined('SYSPATH') or die('No direct script access');

define('required', '<em class="required">*</em>');

for ($j = 0; $j < 100; $j++) {
    $order[] = $j;
}
$i;
?>
<style type="text/css">
    .active-pages-list {
        clear: left;
        margin: .5em 0 0 2em;
    }
    .active-pages-list li {
        margin: .3em;
    }
    .active-pages-list input {
        float: right;
    }
    table {
        float:left;
        text-align: center;
    }
    table td {
        padding: .5em 0;
    }
    table th {
        color: #666;
        text-align: left;
    }
    table caption {
        margin: 0 0 .5em 0;
    }
    #pages td {
        padding: .3em .4em;
    }
    #pages tbody tr {
        background:none repeat scroll 0 0 #F1F1F1;
    }
    #pages tbody tr:hover {
        cursor:pointer;
        background: #9cf !important;

    }
</style>
<div id="sections-wrap">
<?php
foreach($sections as $section) :
    $i++;
    $legend = (empty($section->name)) ? 'Sekcja '.$i : $section->name;
    echo form::fieldset($legend, array('id' => 'section'.$i, 'class' => 'section'));
    if ($action == 'edit' AND isset($item->id)) {
        echo html::anchor('/admin/pages/delete_section/'.$section->id, 'Usuń sekcję', array('class' => 'delete remove'));
    }
?>
    <div style="float:left; margin-bottom: 1em">
    <div class="input-wrap" style="width: 40%">
    <?php
        echo form::label('section-name'.$i, 'Nazwa sekcji'.required);
        echo form::input('sections['.$i.'][name]', $section->name, array('id' => 'section-name'.$i));
        echo form::error($errors[$i]['name']);
        fire::log($errors[$i]);
    ?>
    </div>
    <div class="input-wrap"  style="float: left; width: 10%; clear: none; margin-left: 2em">
    <?php
        echo form::label('section-order'.$i, 'Kolejność');
        echo form::select('sections['.$i.'][ord]', $order, $section->ord, array('id' => 'section-order'.$i));
    ?>
    </div>
    <div class="input-wrap" style="float: left; width: 7%; margin: .5em">
    <?php
        echo form::label('section-global'.$i, 'Globalna', array('style' => "float: right; margin-left: 0"));
        echo form::checkbox('sections['.$i.'][is_global]', 1, isset($section->is_global) ? $section->is_global : FALSE, array('id' => 'section-global'.$i));
    ?>
    </div>
   <div id="section-pages<?php echo $i ?>" style="width: 40%">
        <label>Lista stron zawierających tę sekcję:</label>
        <?php echo html::anchor('#pages-list'.$i,'Wyświetl listę aktywnych stron', array('class' => 'open page-list-caller', 'rel' => $i, 'style' => 'float: right; clear: none')) ?>
        <ul class="active-pages-list">
            <?php
                $section_pages = $section->get_section_pages();
                if ($section_pages) {
                    foreach($section_pages as $page) : ?>
                         <li>
                            <?php
                                $id = $page->id;
                                $title = $page->title;
                                echo form::label('page'.$id, $title);
                                echo form::checkbox('sections['.$i.'][pages]['.$id.'][id]', $id, TRUE, array('id' => 'page'.$id));
                               // echo form::hidden('sections['.$i.'][pages]['.$id.'][title]', $id);
                             ?>
                        </li>
             <?php endforeach; 
                  }
             ?>
        </ul>
    <div id="pages-list<?php echo $i ?>" style="width: 100%;">
    <table cellspacing="0" id="pages">
        <caption class="pages-list-header"></caption>
        <thead>
            <tr>
                <th style="padding: .3em .5em; text-align: left">Tytuł strony</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="page-pagination-links" class="pagination-links"></div>
    </div>
    </div>
    </div>
    <div class="input-wrap">
    <?php
        echo form::label('section-content'.$i, 'Zawartość sekcji'.required);
        echo form::textarea('sections['.$i.'][content]', $section->content, array('id' => 'section-content'.$i));
        echo form::error($errors[$i]['content']);
    ?>
    </div>
    <?php
        echo form::hidden('sections['.$i.'][id]', $section->id);
        echo form::close_fieldset();
endforeach;
?>
</div>
<?php echo html::script('media/js/pagination.js') ?>
<script type="text/javascript">
 function getPages(resultPageId, target, order) {
    var query =  (resultPageId == undefined) ? '' : 'page='+resultPageId,
        id = resultPageId || 1,
        pagesList = $(target).parent().find('div[id^=pages-list]');
            var caption = pagesList.find('caption');

            var pagination = new Pagination('#page-pagination-links', {
                    callback : function(data) {
                                caption.text('Wybierz strony, na których ma pojawić się sekcja.');
                                populatePageTableRows(data, pagesList, order);
                                console.log(data, 'data');
                    },
                    before : function() {
                        caption.text('Pobieranie listy stron...');
                    },
                    url : <?php echo url::site() ?>+'admin/pages/index/10'
                });
       pagination.request(id);
}


function populatePageTableRows(pages, _pagesList, order) {
        var tbody = _pagesList.find('tbody'),
            pagesList = _pagesList,
            activePages = pagesList.parent().find('ul');
        tbody.find('tr').remove();
        for(var key in pages) {
            if(pages.hasOwnProperty(key)) {
                var tr = $('<tr>'),
                    page = pages[key];
                tr.data('id', page.id);
                tr.append($('<td/>')
                            .text(page.title)
                            .addClass('title')
                          )
                  .attr('id', page.id);
                if (isPageActive(pages[key])) {
                    markRow(tr);
                }
                tbody.append(tr);
            }
        }

        tbody.find('tr').click(function() {
            var tr = $(this),
                id = tr.attr('id');
            if (isPageInActiveList(id)) {
                unmarkRow(tr);
                removePageFromActiveList(id);
            } else {
                markRow(tr);
                addPageToActiveList(id, tr.find('td.title').text(), order);
            }

           function isPageInActiveList(id) {
               return activePages.find('input#page'+id).length;
           }

        });

        function removePageFromActiveList(id) {
            return activePages.find('#page' + id).parent().remove();
        }

        function addPageToActiveList(id, title, order) {
            return activePages.append(
                                $('<li/>')
                                       .append($('<label/>')
                                               .attr('for','page'+id)
                                               .text(title)
                                           )
                                       .append(
                                            $('<input/>')
                                            .click(function() {
                                                var input = $(this);
                                                if (input.attr('checked')) {
                                                    input.removeAttr('checked');
                                                } else {
                                                    input.attr('checked', true);
                                                }
                                            })
                                            .attr({
                                                    'type' : 'checkbox',
                                                    'name' : 'sections['+order+'][pages][' + id +'][id]                                    ',
                                                    'value' : id,
                                                    'checked' : true,
                                                    'id' : 'page'+id
                                            })
                                        )
                            )
        }
        function isPageActive(page) {
            return activePages.hasElement('#page'+page.id);
        }
        function markRow(tr) {
            tr.css({'background-color' : '#d5d5d5'});
        }
        function unmarkRow(tr) {
            tr.css({'background-color' : '#f1f1f1'});
        }
};
    $(document).ready(function() {
        $('fieldset[id^=section]').each(function(index, element) {
             index += 1;
             $(element).find('input[type="text"]').each(function() {
                $(this).counter({maxLength : 50});
             });
             var input = $('#section-name' + index),
                target = $('a[href="#section' + index + '"] > .name');
                target.data('default', target.text());
                input.keyup(function() {
                    var text = input.val();
                    if (text.length == 0) {
                        target.text(target.data('default'));
                    } else {
                        target.text(text);
                    }
              });
              var orderSelect = $('#section-order' + index),
                  orderTarget = $('a[href="#section' + index + '"] > .ord');

                  orderSelect.change(function() {
                      orderTarget.text(orderSelect.val());
                  });
        });

        $('input[id^=section-global]').click(function() {
            var input = $(this),
            pageList = input.parent().next();
            if (input.attr('checked')) {
                pageList.hide('fast');
            } else {
                pageList.show('fast');
            }
        });
        $('div[id^=pages-list]').hide();

        $('.page-list-caller').toggle(function(evt) {
             var inv = $(this);
                 inv.removeClass('open').addClass('close');
                 inv.parent().find('div[id^=pages-list]').slideDown('fast');
                 getPages(1, evt.target, inv.attr('rel'));
        }, function(evt) {
             var inv = $(this);
                 inv.removeClass('close').addClass('open');
                 inv.parent().find('div[id^=pages-list]').slideUp('fast');
        });


    });
            

</script>
