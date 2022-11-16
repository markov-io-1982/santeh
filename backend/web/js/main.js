$(function () {

    /* accardeon menu start */
    $('.catalog').dcAccordion({
        speed: 300
    });
    /* accardeon menu end */

    $('.block-tree-pointer').on('click', function () {
        var id = $(this).data('id');
        var idRemove = document.getElementById('hidden_parent').value;
        var idName = $(this).data('name');
        //var idName = $(this).parent('li.list-accor').find('span.block-tree-pointer').text();
        $('#category-view').html('Вы выбрали категорию: <strong>' + idName + '</strong>');
        document.getElementById('hidden_parent').value = id;
        if (idRemove != 0) {
            document.getElementById(idRemove).className = "block-tree-pointer";
        }
        document.getElementById(id).className += ' active';
    });

    console.log('load');

    $(document).ready(function () {
        $(".fancybox").fancybox();
    });

    // выбор языка
    $(document).on('click', '.language', function () {
        console.log('language');
        var lang = $(this).attr('id');

        $.post('/admin/site/language', {
            'lang': lang
        }, function (data) {
            location.reload();
        });
    });

    // product form

    // вызов модального окна создания картинки
    $('#modalButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });

    // удалить связанные изображения
    $(document).on('click', '.delete-images-product', function () {
        var relation = $(this);
        console.log('start delete');
        $.post(
            relation.attr('value')
        ).done(function (result) {
            if (result == true) {
                $.pjax.reload({container: '#realtions_images'});
                $.notify("Successfully deleted", "success");
            }
            else {
                $.notify("Error", "error");
            }
        }).fail(function () {
            $.notify("Server error", "error");
        });
    });


    // вызов модального окна создания связанного продукта
    $('#modalButtonProduct').click(function () {
        $('#modal_product').modal('show')
            .find('#modalContentProduct')
            .load($(this).attr('value'));
    });


    // удалить связанный продукт
    $(document).on('click', '.delete-rel-product', function () {
        var relation = $(this);
        console.log('start delete');
        $.post(
            relation.attr('value')
        ).done(function (result) {
            if (result == 1) {
                $.pjax.reload({container: '#realtions_product'});
                $.notify("Successfully deleted", "success");
            }
            else {
                $.notify("Error", "error");
            }
        }).fail(function () {
            $.notify("Server error", "error");
            console.log("server error");
        });
    });

    // вызов модального окна создания связанного атрибута
    $('#modalButtonAttribute').click(function () {
        $('#modal_attribute').modal('show')
            .find('#modalContentAttribute')
            .load($(this).attr('value'));
    });

    // удалить связанный атрибут
    $(document).on('click', '.delete-rel-attribute', function () {
        var relation = $(this);
        console.log('start delete');
        $.post(
            relation.attr('value')
        ).done(function (result) {
            if (result == 1) {
                $.pjax.reload({container: '#realtions_attribute'});
                $.notify("Successfully deleted", "success");
            }
            else {
                $.notify("Error", "error");
            }
        }).fail(function () {
            $.notify("Server error", "error");
        });
    });


    // вызов модального окна создания комбинации продукта
    $(document).on('click', '.modalButtonCombination', function () {
        $('#modal_combination').modal('show')
            .find('#modalContentCombination')
            .load($(this).attr('value'));
    });

    // удалить комбинацию продукта
    $(document).on('click', '.delete-product-combination', function () {
        var combination = $(this);
        console.log('start delete');
        $.post(
            combination.attr('value')
        ).done(function (result) {
            if (result == true) {
                $.pjax.reload({container: '#product_combinations'});
                $.notify("Successfully deleted", "success");
            }
            else {
                $.notify("Error", "error");
            }
        }).fail(function () {
            $.notify("Server error", "error");
        });
    });

// crop image

    $(document.body).on('submit', '#crop_form', function (e) {

        var frm = $(this); //just sent text

        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            dataType: 'json',
            data: frm.serialize(),
            success: function (data) {

                if (data) {

                    //do something
                }
            },
        });
        return false;
    });


    $('#update-course').click(function (event) {
        $.ajax({
            url: '/site/updatecourse',
            type: 'get',
            dataType: 'json',
            data: {query: 'getCourse'},
        })
            .done(function (result) {
                if (result != false) {
                    $.notify("Course updated", "success");

                    $('.cour_usd_uah').html(result.usd_uah);
                    $('.cour_usd_eur').html(result.usd_eur);
                    $('.cour_usd_rub').html(result.usd_rub);
                    //console.log(result);
                }
                else {
                    $.notify("Error", "error");
                }
            }).fail(function () {
            $.notify("Server error", "error");
        });

        return false;

    });


});

