<?php defined('SYSPATH') or die('No direct script access');
   create_link('Dodaj nową', 'pages', 'add', null, array('class' => 'create', 'style' => 'float: left; margin-left: 1em'));
   echo '<div class="items-count-chooser">';
   $attr = array('method' => 'get');
       $all_pages = html::anchor('admin/pages', 'Wyświetl listę wszystkich stron', array('style' => 'font-size: 115%; line-height: 2em'));
//   if (Request::instance()->action == 'search') {
//       $attr['style'] = 'display: none';
//       }
//   echo form::open('admin/pages', $attr);
//   echo form::label('items_per_page', 'Ilość widocznych stron:');
//   echo form::select('items_per_page', array(10 => 10, 20 => 20, 30 => 30, 40 => 40, 50 => 50)
//                    ,(isset($_GET['items_per_page'])) ? $_GET['items_per_page'] : 10,
//                      array('id' => 'items_per_page'));
//   echo form::submit('show_items', 'Pokaż');
//   echo form::close();
   echo '</div>';
   echo form::open('admin/pages/delete');
   if ($pages->count() == 0) { ?>
<p>Niczego nie znaleziono. <?php echo $all_pages ?></p>

<?php   }
   else {
?>
<p> <?php if (Request::instance()->action == 'search') echo $all_pages ?></p>
<table cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="mark">&nbsp;</th>
            <th scope="col" class="name">Tytuł strony</th>
            <th scope="col">Utworzona</th>
            <th scope="col">Zmodyfikowana</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th scope="col" class="mark">&nbsp;</th>
            <th scope="col" class="name">Tytuł strony</th>
            <th scope="col">Utworzona</th>
            <th scope="col">Zmodyfikowana</th>
        </tr>
    </tfoot>
    <tbody>
        <?php foreach($pages as $page) : $id = $page->id  ?>
        <tr title="Kliknij aby zaznaczyć">
            <td class="mark"><?php echo form::checkbox('pages[]', $id) ?>
            </td>
            <td class="name"><em><?php if($page->is_main) { echo '<strong>(Strona główna)</strong> '.$page->title; } else echo $page->title; ?></em>
                <div>
                    <?php
                     create_link('Podglądnij', 'pages', 'preview', $id, array('title' => 'Podglądnij'));
                     create_link('Edytuj', 'pages', 'edit', $id, array('title' => 'Edytuj'));
                     create_link('Usuń', 'pages', 'delete', $id, array('title' => 'Usuń', 'class' => 'delete'));
                     ?>
                </div>
            </td>
            <td><?php echo $page->created ?></td>
            <td><?php  if (! strtotime($page->last_modified) == 0) echo $page->last_modified  ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div style="float: left;">
    [ <a href="#" class="mark-all" style="padding-right: .3em">Zaznacz wszystkie</a>
    <a href="#" class="unmark-all" style="padding-right: .3em">Odznacz wszystkie</a>
    ] Zaznaczone: 
    <?php echo form::submit('remove-submit', 'Usuń', array('class' => 'condition-submit', 'style' => 'float: none;'))?>
</div>
<?php 
    echo form::close();
    echo $pagination;
}
?>
<!--<div id="c-dialog">
    <div id="c-icon"></div>
    <em>Czy napewno chcesz usunąć?</em>
    <div>
        <a href="#" id="yes">Tak</a>
        <a href="#" id="no">Nie</a>
    </div>
</div> -->
<?php echo html::script('media/js/jquery.c-dialog.js') ?>
<script type="text/javascript">
 $(document).ready(function() {
     $(':checkbox').removeAttr('checked');
     $('tbody > tr').each(function(index) {
        var tr = $(this);
        tr.find('td.name div').hide();
        ((index & 1) == 0) ? tr.addClass('even') : tr.addClass('odd');
        tr.click(function() {
           var tr = $(this);
           (tr.hasClass('marked')) ? unmarkRow(tr) : markRow(tr);
        }).hover(function() {
            tr.find('td.name > div').show();
        }, function() {
            tr.find('td.name > div').hide();
        });
     });
    
     function markRow(row) {
         row.find(':checkbox').attr('checked', true);
         row.addClass('marked');
     }

     function unmarkRow(row) {
         row.find(':checkbox').attr('checked', false);
         row.removeClass('marked');
     }



//    $('.delete').each(function() {
//        $(this).c_dialog({
//        after_no : function(inv, evt) {
//                       var tr = inv.closest('tr:first');
//                       unmarkRow(tr);
//                 }}
//            );
//    });
    $('.delete').each(function() {
        $(this).c_dialog();
    });

    function putMsgAfterInv(invoker, message) {
        var msg = $('<em class="confirm-msg" />');
        if (typeof(message) == 'object' && message != null) {
            msg.text(message.msg).append(message.yes).append(message.no);
        } else msg.text(message);
        $('.confirm-msg').remove();
        invoker.after(msg);
    }

    function areInputsChecked() {
        return $('input[type=checkbox]:checked').length;
    }

    function createConfirmation(question, action) {
        var yes = $('<a class="allow"/>').click(function() {
            action();
            return false;
        }).text(' Tak ');
        var no = $('<a class="denied"/>').click(function(){
            $('.confirm-msg').remove();
            return false;
        }).text(' Nie');
        return {
            'msg' : question,
            'yes' : yes,
            'no' : no
        };
    }

    $('.condition-submit').click(
        function(evt) {
            var deniedMsg = 'Przynajmniej jedna strona musi być zaznaczona';
            var submit = $(this);
            if (! areInputsChecked()) {
                putMsgAfterInv(submit, deniedMsg);
            } else {
                var confirm = createConfirmation('Czy napewno usunąć zaznaczone strony?:', function() {
                    if (areInputsChecked()) {
                        submit.parents('form').submit();
                    } else {
                        putMsgAfterInv(submit, deniedMsg);
                    }
                });
                putMsgAfterInv(submit, confirm);
            }
            return false;
        }
    );

    $('.mark-all').click(function(evt) {
       evt.preventDefault();
        $('tbody > tr').each(function() {
           markRow($(this));
        });
    });
    $('.unmark-all').click(function(evt) {
        evt.preventDefault();
        $('tbody > tr').each(function() {
           unmarkRow($(this));
        });
    });
//    $('.pagination a').each(function() {
//        var currA = $(this);
//        currA.click(function() {
//            var selectedVal = parseInt($('#items_per_page').val()),
//                old_href = currA.attr('href'),
//                new_href = '';
//            if (old_href.indexOf('items_per_page') != -1) {
//                    var length = old_href.length;
//                    old_href = old_href.substr(0, length - 2);
//                    new_href = old_href + selectedVal;
//            } else {
//                new_href = old_href + '&items_per_page=' + selectedVal;
//            }
//            currA.attr('href', new_href);
//        });
//
//    });
//
    

 


//    $(':checkbox').toggle(
//        function() {
//            $(this).attr('checked', 'checked');
//        },
//        function() {
//            $(this).removeAttr('checked');
//        }
//     );
//        $('.delete-link')
//        .click(function(evt) {
//            console.log('click');
//            if ($(':checkbox[checked]').length === 0) {
//                console.log('no cb selected');
//                return false;
//            }
//        })
//        .c_dialog({
//
//        });


 });
</script>
