

    function on_window_resize(e) {
        let h1 = $('.header').outerHeight(true);
        let h2 = $(window).height();
        let h3 = parseInt($(document.body).css('margin-top')) + parseInt($(document.body).css('margin-bottom'));

        let h = h2 - h1 - h3;

        $('#excel-grid').height(h);
    }

    function on_cell_click(e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).addClass('editing');

        this.undo = this.textContent;
        this.setAttribute('style', 'text-overflow: clip;');

        this.setAttribute('contentEditable','true');

        this.focus();
    }

    function on_cell_blur(e) {
        if(this.getAttribute('ContentEditable') === 'true'){
            cell_value_update(this);
        }
    }

    function on_cell_keydown(e) {

        if(e.keyCode == 13 || e.keyCode == 27) {
            e.preventDefault();

            if (e.keyCode == 27) {
                this.textContent = this.undo;
            }

            cell_value_update(this);
        }
    }

    function cell_value_update(cell) {
        if (cell.textContent !== cell.undo) {
            let o = JSON.parse($(cell).attr('data-cell'));
            o.v = $(cell).text();
            $(cell).attr('data-cell', JSON.stringify(o));
        }

        delete cell.undo;

        $(cell)
            .removeClass('editing')
            .removeAttr('contentEditable')
            .removeAttr('style')
            .removeAttr('editing')
            .scrollLeft(0)
    }

    function on_excel_file_load(e) {

        let data = new Uint8Array(e.target.result);                 // ExcelデータをUint8Arrayオブジェクトに格納。
        let workbook = XLSX.read(data, {type: 'array'});            // Sheet JS で使う workbookオブジェクト の作成。
        let name = workbook.SheetNames[0];                          // シート名取得。
        let work_sheet = workbook.Sheets[name];                     // シート名から、worksheetオブジェクトを取得。
        let range = XLSX.utils.decode_range(work_sheet['!ref']);    // シート全範囲を取得
        let column_num = range.e.c + 1;                             // 列数を取得

        let header_array = ['配送先カテゴリー', '配送先名', 'フリガナ'];

        $('.row.head, .row.body').empty();
        $('.row.head,.row.body').css('grid-template-columns','repeat(' + column_num.toString() + ',1fr)');

        let json = XLSX.utils.sheet_to_json(work_sheet,{header:1})
        $.each(json[0], function(i, val) {

            $('<button>')
                .addClass('header_button')
                .text(val)
                .appendTo($('#headers'));
        });

        let $head = $('#excel-grid > .head');
        let $body = $('#excel-grid > .body');

        $.each(json,function(i,arr) {
            let to = i == 0 ? $head : $body;
            for(let j=0;j<column_num;j++)
            {
                var v = arr[j] ? arr[j].toString() : '';
                var celldata = {'r':i,'c':j,'v':v};
                var attrs = {
                    'data-cell': JSON.stringify(celldata),
                    'title': v
                };
                $('<span>')
                    .addClass('cell')
                    .attr(attrs)
                    .text(v)
                    .appendTo(to);
            }
        });
    }