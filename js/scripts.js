/**
 * Created by ivanj on 17-Feb-17.
 */

$(document).ready(function () {
    $(".btnAddCharacter").click(function () {
        /*var html = '<div class="col-md-3 userCharacterSlots"><div class="row"><div class="col-md-12 userCharacterSlotsPicture"></div><p><a href="#">Character name</a><p style="color: darkslategray"> Character nickname </p><p style="color: #1b6d85"> Lorem Ipsum is simply dummy text of the printing and typesetting industry.Lorem Ipsum has been the industrys standard dummy text ever since the 1500s,when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p></p></div></div>';
        $(".addCharacterInUser").append(html);*/

        $("#addNewCharacter").modal();
    });

    $(".btnLogOut").click(function () {
        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "logout"
            },
            success : function (response) {
                if(response == "OK")
                {
                    window.location.href = "index.php";
                }
            }
        });
    });

    $(".btnEditInfo").click(function () {
        $("#editInfo").modal();
    });

    $("#btnEditInfoForm").click(function (event) {
        event.preventDefault();
        
        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "editUserDesc",
                "desc" : $("#description").val()
             },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
            }
        });
        

    });

    $(".btnAddProfilePic").click(function () {
        $("#changeProfilePic").modal();
    });

    $("#btnUploadProfilePic").click(function (event) {
        event.preventDefault();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "pictureUrl",
                "url" : $("#picUrl").val()
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
                else
                {
                    alert(response);
                }
            }
        });
    });

    $(".btnDeleteChar").click(function () {
        var charId = $("#charId").val();
        var userId = $("#userId").val();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "deleteChar",
                "charId" : charId
            },
            success : function (response) {
                if(response == "OK")
                {
                    window.location.href = "userProfile.php?uid="+userId;
                }
                else
                {
                    alert(response);
                }
            }
        });
    });

    $(".btnEditCharDesc").click(function () {
        $("#editCharDesc").modal();
    });

    $("#btnEditCharDescForm").click(function (evenet) {
        event.preventDefault();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "editCharDesc",
                "charId" : $("#charId").val(),
                "charDesc" : $("#charDesc").val()
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
                else
                {
                    alert(response);
                }
            }
        });

    });

    $('.btnPassReset').click(function () {
        window.location.href = "passwordChange.php";
    });

    $('.btnEditCharAttr').click(function () {
        $('#editCharAttributeForm').modal();
    });

    $('#btnChangeCharAttr').click(function (event) {
        event.preventDefault();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "editCharAttr",
                "attrValue" : $("#newAttr").val(),
                "attribute" : $("#charSelectAttr").val(),
                "charId" : $("#charId").val()
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
                else
                {
                    alert(response);
                }
            }
        });
    });

    $('.btnChangeCharPic').click(function () {
        $('#changeCharPicture').modal();
    });

    $('#btnUploadCharPicture').click(function (event) {
        event.preventDefault();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "charPicture",
                "url" : $('#charPicUrl').val(),
                "charId" : $('#charId').val()
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
                else
                {
                    alert(response);
                }
            }
        });

    });

    $(".btnAddPicLink").click(function () {
        $('#addPicLink').modal();
    });

    $('#btnAddLink').click(function (event) {
        event.preventDefault();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "picLink",
                "url" : $('#picLink').val(),
                "charId" : $('#charId').val()
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
                else
                {
                    alert(response);
                }
            }
        });
    });

    $('.removeLink').click(function () {
        var id = this.id;

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "removeLink",
                "id" : id
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    location.reload();
                }
                else
                {
                    alert(response);
                }
            }
        });
    });

    $('#keyword').on('input', function() {
        var searchKeyword = $(this).val();

        if(searchKeyword.length >= 3)
        {
            var searchType = $("input[name='searchType']:checked").val();
            $.ajax({
                url: "search.php",
                type: "POST",
                data: {
                    "keywords" : searchKeyword,
                    "searchType" : searchType
                },
                success : function (response) {
                    try{
                        var results = JSON.parse(response);
                        $("ul#content").empty();
                        $.each(results,function () {
                            if(this.searchType == "searchUser")
                            {
                                $("ul#content").append('<li><a href="userProfile.php?uid=' + this.id + '">' + this.title + '</a></li>');
                            }
                            if(this.searchType == "searchCharacter")
                            {
                                $("ul#content").append('<li><a href="characterProfile.php?cid=' + this.id + '">' + this.title + '</a></li>');
                            }


                        });
                    }
                    catch (e){
                        $("ul#content").empty();
                        $("ul#content").append('<li>'+ response +'</li>')
                    }
                }
            });
        }
        else
        {
            $("ul#content").empty();
        }
    });

    $(".btnDeleteUser").click(function () {
        $("#deleteAccount").modal();
    });

    $(".btnCancelDelete").click(function () {
        $.modal.close();
    });

    $(".btnConfirmDelete").click(function () {
        var id = $("#cookieId").val();

        $.ajax({
            url: "functions.php",
            type: "POST",
            data: {
                "data" : "deleteAccount",
                "id" : id
            },
            success : function (response) {
                if(response == "OK")
                {
                    $.modal.close();

                    window.location.href = "index.php";
                }
                else
                {
                    alert(response);
                }
            }
        });
    });
});