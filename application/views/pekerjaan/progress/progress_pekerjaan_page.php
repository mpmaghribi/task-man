<?php $this->load->view("taskman_header_page") ?> 
    <body>
        <section id="container">
            <!--header start-->
            <?php $this->load->view("taskman_header2_page") ?>
            <!--header end-->
            <!--sidebar start-->
            <?php $this->load->view("taskman_sidebarleft_page") ?>
            <!--sidebar end-->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <section class="panel">
                                <header class="panel-heading">
                                    List of tasks
                                </header>
                                <div class="panel-body">
                                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Points</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="">
                                    <td>Jonathan</td>
                                    <td>Smith</td>
                                    <td>3455</td>
                                    <td class="center">Lorem ipsume</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Mojela</td>
                                    <td>Firebox</td>
                                    <td>567</td>
                                    <td class="center">new user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Akuman </td>
                                    <td> Dareon</td>
                                    <td>987</td>
                                    <td class="center">ipsume dolor</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Theme</td>
                                    <td>Bucket</td>
                                    <td>342</td>
                                    <td class="center">Good Org</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Jhone</td>
                                    <td> Doe</td>
                                    <td>345</td>
                                    <td class="center">super user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Margarita</td>
                                    <td>Diar</td>
                                    <td>456</td>
                                    <td class="center">goolsd</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Jhon Doe</td>
                                    <td>Jhon Doe </td>
                                    <td>1234</td>
                                    <td class="center"> user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Helena</td>
                                    <td>Fox</td>
                                    <td>456</td>
                                    <td class="center"> Admin</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Aishmen</td>
                                    <td> Samuel</td>
                                    <td>435</td>
                                    <td class="center">super Admin</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>dream</td>
                                    <td>Land</td>
                                    <td>562</td>
                                    <td class="center">normal user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>babson</td>
                                    <td> milan</td>
                                    <td>567</td>
                                    <td class="center">nothing</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Waren</td>
                                    <td>gufet</td>
                                    <td>622</td>
                                    <td class="center">author</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Jhone</td>
                                    <td> Doe</td>
                                    <td>345</td>
                                    <td class="center">super user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Margarita</td>
                                    <td>Diar</td>
                                    <td>456</td>
                                    <td class="center">goolsd</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Jhon Doe</td>
                                    <td>Jhon Doe </td>
                                    <td>1234</td>
                                    <td class="center"> user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Helena</td>
                                    <td>Fox</td>
                                    <td>456</td>
                                    <td class="center"> Admin</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Aishmen</td>
                                    <td> Samuel</td>
                                    <td>435</td>
                                    <td class="center">super Admin</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>dream</td>
                                    <td>Land</td>
                                    <td>562</td>
                                    <td class="center">normal user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>babson</td>
                                    <td> milan</td>
                                    <td>567</td>
                                    <td class="center">nothing</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Waren</td>
                                    <td>gufet</td>
                                    <td>622</td>
                                    <td class="center">author</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Jhone</td>
                                    <td> Doe</td>
                                    <td>345</td>
                                    <td class="center">super user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Margarita</td>
                                    <td>Diar</td>
                                    <td>456</td>
                                    <td class="center">goolsd</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Jhon Doe</td>
                                    <td>Jhon Doe </td>
                                    <td>1234</td>
                                    <td class="center"> user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Helena</td>
                                    <td>Fox</td>
                                    <td>456</td>
                                    <td class="center"> Admin</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Aishmen</td>
                                    <td> Samuel</td>
                                    <td>435</td>
                                    <td class="center">super Admin</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>dream</td>
                                    <td>Land</td>
                                    <td>562</td>
                                    <td class="center">normal user</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>babson</td>
                                    <td> milan</td>
                                    <td>567</td>
                                    <td class="center">nothing</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                <tr class="">
                                    <td>Waren</td>
                                    <td>gufet</td>
                                    <td>622</td>
                                    <td class="center">author</td>
                                    <td><a class="edit" href="javascript:;">Edit</a></td>
                                    <td><a class="delete" href="javascript:;">Delete</a></td>
                                </tr>
                                </tbody>
                            </table>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </section>
            <!--script for this page only-->
<script src="<?php echo base_url()?>assets/js/table-editable.js"></script>

<!-- END JAVASCRIPTS -->
<script>
    jQuery(document).ready(function() {
        EditableTable.init();
    });
</script>
            <!--main content end-->
            <!--right sidebar start-->
            <?php $this->load->view('taskman_rightbar_page')?>
            <!--right sidebar end-->
        </section>
            <?php $this->load->view("taskman_footer_page") ?>