var Script = function () {

//    $.validator.setDefaults({
//        submitHandler: function() { alert("submitted!"); }
//    });

    $().ready(function() {
        // validate the comment form when it is submitted
        $("#commentForm").validate();
        
         $("#id_progress").validate({
             rules:{
                 progress_val:{
                     required: true,
                     max: 100
                 }
             }
         });

        // validate signup form on keyup and submit
        $("#form_tambah_pekerjaan2").validate({
            rules: {
                topik_pengaduan: "required",
                isi_pengaduan: "required",
                tgl_pengaduan: "required",
                urgensitas: "required",
                nama_pkj: "required",
                deskripsi_pkj: "required",
                tgl_mulai_pkj: "required",
                tgl_selesai_pkj: "required",
                sifat_pkj: "required",
                prioritas: "required",
                nama_pkj2: "required",
                deskripsi_pkj2: "required",
                tgl_mulai_pkj2: "required",
                tgl_selesai_pkj2: "required",
                sifat_pkj2: "required",
                prioritas2: "required",
                firstname: "required",
                lastname: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                fullname: {
                    required: true,
                    minlength: 2
                },
                userpassword: {
                    required: true,
                    minlength: 5
                },
                confirmuserpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#userpassword"
                },
                email: {
                    required: true,
                    email: true
                },
                religion: {
                    required: true                    
                },
                homephone: {
                    required: true,
                    number: true,
                    digits: true
                },
                mobilephone: {
                    required: true,
                    number: true,
                    digits: true
                },
                address: {
                    required: true
                },
                jabatan: {
                    required: true
                },
                departemen: {
                    required: true
                },
                'gender[]': {
                    required: true
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                fullname: {
                    required: "Please enter your full name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                userpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirmuserpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                email: "Please enter a valid email address",
                agree: "Please accept our policy"
            }
        });
        $("#signupForm, #form_tambah_pekerjaan, #progress_form").validate({
            rules: {
                topik_pengaduan: "required",
                perubahan: "required",
                nama_file: "required",
                progress: "required",
                isi_pengaduan: "required",
                tgl_pengaduan: "required",
                urgensitas: "required",
                nama_pkj: "required",
                deskripsi_pkj: "required",
                tgl_mulai_pkj: "required",
                tgl_selesai_pkj: "required",
                sifat_pkj: "required",
                prioritas: "required",
                nama_pkj2: "required",
                deskripsi_pkj2: "required",
                tgl_mulai_pkj2: "required",
                tgl_selesai_pkj2: "required",
                sifat_pkj2: "required",
                prioritas2: "required",
                firstname: "required",
                lastname: "required",
                username: {
                    required: true,
                    minlength: 2
                },
                fullname: {
                    required: true,
                    minlength: 2
                },
                userpassword: {
                    required: true,
                    minlength: 5
                },
                confirmuserpassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#userpassword"
                },
                email: {
                    required: true,
                    email: true
                },
                religion: {
                    required: true                    
                },
                homephone: {
                    required: true,
                    number: true,
                    digits: true
                },
                mobilephone: {
                    required: true,
                    number: true,
                    digits: true
                },
                address: {
                    required: true
                },
                jabatan: {
                    required: true
                },
                departemen: {
                    required: true
                },
                'gender[]': {
                    required: true
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                agree: "required"
            },
            messages: {
                firstname: "Please enter your firstname",
                lastname: "Please enter your lastname",
                username: {
                    required: "Please enter a username",
                    minlength: "Your username must consist of at least 2 characters"
                },
                fullname: {
                    required: "Please enter your full name",
                    minlength: "Your name must consist of at least 2 characters"
                },
                userpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirmuserpassword: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long",
                    equalTo: "Please enter the same password as above"
                },
                email: "Please enter a valid email address",
                agree: "Please accept our policy"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if(firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });

        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });


}();