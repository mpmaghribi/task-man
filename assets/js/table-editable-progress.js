var EditableTableProgress = function() {

    return {
        //main function to initiate the module
        init: function() {
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" readonly class="form-control small" value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" style="display:none" readonly class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" readonly class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<input type="number" class="form-control small" min="0" max="100" step="10" placeholder="0-100%" value="' + aData[3] + '';
                jqTds[4].innerHTML = '<a class="edit" href="">Simpan</a>';
                jqTds[5].innerHTML = '<a class="cancel" href="">Batal</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit" href="">Ubah Progress</a>', nRow, 4, false);
                oTable.fnUpdate('<a class="#" href=""></a>', nRow, 5, false);
                oTable.fnDraw();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit" href="">Ubah Progress</a>', nRow, 4, false);
                oTable.fnDraw();
            }

            function savetodb(nRow)
            {

                $.ajax({// create an AJAX call...
                    data:
                            {
                                id_detail_pkj: nRow.cells[0].innerHTML,
                                data_baru: nRow.cells[3].innerHTML
                            }, // get the form data
                    type: "POST", // GET or POST
                    url: "http://localhost:90/taskmanagement/index.php/pekerjaan/update_progress", // the file to call
                    cache: false,
                    success: function(response) { // on success..
                        var json = jQuery.parseJSON(response);

                        if (json.status === "OK") {
                            alert("Updated!");
                            window.location.href = "";
                        } else {
                            alert("Data gagal di update");
                        }
                    }
                });
            }

            $('#table_deskripsi,#tabel_pekerjaan_staff,#tabel_usulan_pekerjaan').dataTable({
                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row'f<'col-lg-6'>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            $('#tabel_pkj_saya,#tabel_pkj_saya2').dataTable({
                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row'f<'col-lg-6'>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            $('#tabel_home').dataTable({
                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row'f<'col-lg-6'>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
            $('#tabel_komentar').dataTable({
                // set the initial value
                "iDisplayLength": 3,
                "sDom": "<'row'<'col-lg-6'>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });
            
//            var oTable = $('#editable-sample').dataTable({
//                "aLengthMenu": [
//                    [5, 15, 20, -1],
//                    [5, 15, 20, "All"] // change per page values here
//                ],
//                // set the initial value
//                "iDisplayLength": 5,
//                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
//                "sPaginationType": "bootstrap",
//                "oLanguage": {
//                    "sLengthMenu": "_MENU_ records per page",
//                    "oPaginate": {
//                        "sPrevious": "Prev",
//                        "sNext": "Next"
//                    }
//                },
//                "aoColumnDefs": [{
//                        'bSortable': false,
//                        'aTargets': [0]
//                    }
//                ]
//            });

            var oTable = $('#editable-sample').dataTable({
                // set the initial value

                // set the initial value
                "iDisplayLength": 5,
                "sDom": "<'row'f<'col-lg-6'><'col-lg-6'>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0, 1, 4, 5]
                    }
                ]
            });

            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

            var nEditing = null;

            $('#editable-sample_new').click(function(e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                    '<a class="edit" href="">Edit</a>', '<a class="cancel" data-mode="new" href="">Cancel</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#editable-sample a.delete').live('click', function(e) {
                e.preventDefault();

                if (confirm("Are you sure to delete this row ?") == false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];
                oTable.fnDeleteRow(nRow);
                alert("Deleted! Do not forget to do some ajax to sync with backend :)");
            });

            $('#editable-sample a.cancel').live('click', function(e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);

                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                    window.location.href = "";
                }
            });

            $('#editable-sample a.edit').live('click', function(e) {
                e.preventDefault();

                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];

                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Simpan") {
                    /* Editing this row and want to save it */
                    saveRow(oTable, nEditing);
                    nEditing = null;
                    savetodb(nRow);

                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
            });
        }

    };

}();