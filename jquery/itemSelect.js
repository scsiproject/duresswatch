$(document).ready(function () {

   // $(".nav .tracksTab a").prop("disabled",true);

    // $(document).on('click','#selectAction', function(){
    //     if($(this).val()==="otherAction") {
    //         $('.inputAction').show()
    //     }else{
    //         $('.inputAction').hide()
    //     }
    //
    // });

   // $('#loader').fadeOut("slow");


    var table_count = 0;

    setInterval(function() {
        $.ajax({
            type: "POST",
            url: "checkcount.php",
            success: function(data) {
                if (data != table_count) {
                    $('.loader').hide();
                    load_event();
                    console.log("change detected!");
                    table_count = data;
                    if (data == 0) {
                        $('#eventUpdates').html("");
                        $('#employeeEventDetails').html("");
                        myMap();
                    }
                }
            }
        });

    }, 5000);

    load_event();
    function load_event(query) {
       // $('#EventLoadingMessage').show();
        $.ajax({
            url: "commandAjaxInfo.php",
            method: "POST",
            data:{
                query:query
            },
            // beforeSend: function(){
            //     $('#loader').show();
            // },

            success: function(data) {
                $('#eventUpdates').html(data);
               // $('#EventLoadingMessage').hide();
            }
            // complete:function(data){
            //     // Hide image container
            //     $('#loader').hide();
            // },

        });
    }


    load_details_event();
    function load_details_event(query){
        //$('#EventLoadingMessage').show();
        $.ajax({
            url: "employeeEventDetailsList.php",
            method: "POST",
            data:{
                query:query

            },
            // beforeSend: function(){
            //     $('#EventLoadingMessage').show();
            // },

            success: function(data) {
                $('#reportUpdates').html(data);
            //   $('#EventLoadingMessage').hide();

            }
            // complete:function(data){
            //     // Hide image container
            //     $('#EventLoadingMessage').hide();
            // },
        });
    }

    $('#reportUpdates').on('click', '.pagination a', function(e){
        //alert("hit paging number");
        e.preventDefault();
        $("#EventLoadingMessage").show(); //show loading element
        var page = $(this).attr("data-page"); //get page number from link
        $("#reportUpdates").load("employeeEventDetailsList.php",{"page":page}, function(){ //get content from PHP page
            $("#EventLoadingMessage").hide(); //once done, hide loading element
        });
    });


    //
    // load_filtered_report();
    // function load_filtered_report(q){
    //     var from_date = $("#from_date").val();
    //     var to_date = $("#to_date").val();
    //     var br = $('#branch').val();
    //     var empl = $('#employeeList').val();
    //
    //     if(from_date != '' && to_date != '')
    //     {
    //         $.ajax({
    //             url:"filter.php",
    //             method:"POST",
    //             data:{
    //                 q: q,
    //                 from_date: from_date,
    //                 to_date: to_date,
    //                 br: br,
    //                 empl: empl
    //             },
    //             beforeSend: function(){
    //                 $(".loader").show();
    //             },
    //             success:function(data)
    //             {
    //                 $('#reportUpdates').html(data);
    //                 $('#pagination_controls').hide();
    //             },
    //             complete:function(data){
    //                 // Hide image container
    //                 $(".loader").hide();
    //             }
    //         });
    //     }
    // }

    $(document).on('click', '.pagination_link', function(){
        var query = $(this).attr("id");
        load_all_report(query);

    });

    $(document).on('click', '.pagination_link_clicked', function(){
        var q = $(this).attr("id");
        load_filtered_report(q);

    });


    $(document).on('click','#StaffTableRowItem',function () {
        $('.selected'). removeClass('selected');
        $(this).addClass("selected");
        var waidn = $(this).find(".waidn").html();
        var evidn = $(this).find(".evidn").html();
        console.log(waidn);

        // $(".nav .tracksTab a").prop("enabled",true);

        $.post('employeeMainEventList.php',{
            waidn:waidn

        }, function(data) {

            $('#employeeMainEventDetails').html(data);

        });

        $.post('mapLat.php', {
            waidn:waidn
        }, function(data) {
            google.maps.event.addDomListener(window, 'load', loadMap);
            var str = data;
            var strsp = str.split("/"),
                lat = strsp[0],
                lon = strsp[1];
            console.log(lat);
            console.log(lon);

            function loadMap(lat, lon) {

                var coords = {
                    lat: lat,
                    lng: lon
                };
                // The map
                var map = new google.maps.Map(
                    document.getElementById('googleMap'), {
                        zoom: 16,
                        center: coords,
                        gestureHandling: 'cooperative'
                    });
                // The marker
                var marker = new google.maps.Marker({
                    position: coords,
                    map: map,
                    title: waidn
                });

            }
            loadMap(parseFloat(lat), parseFloat(lon));
        });

        $.post('trackMap.php', {
            waidn:waidn
        }, function(data) {
            google.maps.event.addDomListener(window, 'load', loadMap);
            var str = data;
            var strsp = str.split("/"),
                lat = strsp[0],
                lon = strsp[1];
            console.log(lat);
            console.log(lon);

            function loadMap(lat, lon) {

                var coords = {
                    lat: lat,
                    lng: lon
                };
                // The map
                var map = new google.maps.Map(
                    document.getElementById('trackMaps'), {
                        zoom: 16,
                        center: coords,
                        gestureHandling: 'cooperative'
                    });
                // The marker
                var marker = new google.maps.Marker({
                    position: coords,
                    map: map,
                    title: waidn
                });

            }
            loadMap(parseFloat(lat), parseFloat(lon));
        });


        $.post('ret_staffid.php', {
            waidn: waidn
        }, function(data) {
            $("input[name='in_stidn']").val(data);
            console.log(data);
        });




        $(document).on('click','.list',function () {
            var list_id = $(this).attr('id');
            console.log('list_id: ' +list_id);

            $.ajax({
                url: "updateAlert.php",
                method: "POST",
                data: {
                    list_id: list_id,
                    waidn:waidn
                },
                success: function(data) {
                    swal("Success!",data,"success");
                    location.reload();
                }
            });
        });




        $(document).on('change', '#selectAction', function () {
            var actionType = $(this).val();
            if($(this).val() == "makeCall") {
                $.ajax({
                    url: "callAction.php",
                    method: "POST",
                    data: {
                        actionType: actionType,
                        waidn: waidn,
                        evidn: evidn
                    },
                    success: function (data) {
                        swal({
                            title: 'Call ' + waidn + '?',
                            html: '<div id="c2k_container_0" title="" style="text-align: center;">',
                            showCancelButton: true,
                            cancelButtonColor: '#d33',
                        }).then(function (result) {
                            if (result.value) {
                                var left = ($(window).width() / 2) - (900 / 2);
                                var top = ($(window).height() / 2) - (600 / 2);
                                window.open("ccc_scsi_duress.html?waidn=" + waidn + " ", "newwindow", "width=100, height=10, top=" + top + ", left=" + left);
                                return false;
                                let timerInterval
                                swal({
                                    title: 'Calling ' + waidn + '...',
                                    timer: 10000,
                                    onOpen: function () {
                                        swal.showLoading()
                                        timerInterval = setInterval(function () {
                                            // swal.getContent().querySelector('strong')
                                            //   .textContent = swal.getTimerLeft()
                                        }, 100)
                                    },
                                    onClose: function () {
                                        clearInterval(timerInterval)
                                    }
                                }).then(function (result) {
                                    if (
                                        // Read more about handling dismissals
                                        result.dismiss === swal.DismissReason.timer
                                    ) {
                                        console.log(waidn + ' called.');
                                    }
                                })
                            }
                        })
                    }
                });
            }
            else if($(this).val() == "listenAudio"){
                var ev = $(".ev_t").html();
                $.ajax({
                    url: "audAction.php",
                    method: "POST",
                    data: {
                        waidn: waidn,
                        ev: ev,
                        evidn:evidn,
                        actionType: actionType,
                    },
                    success: function(data) {
                        window.open(data, "newwindow");
                        console.log(data);
                    }
                })
            }
            else {

                if($(this).val() == "otherAction"){
                    $('#inputActionField').show();
                }else{
                    $('inputActionField').hide();
                }

                $('#inputActionField').on('keypress', function(){
                    var query = $("#inputActionField").val();
                    var actionType  = query;

                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    // $("#EventLoadingMessageAudio").show();
                    if(keycode == '13') {

                        $.ajax({

                            method: "POST",
                            url: "otherAction.php",
                            data: {
                                actionType: actionType,
                                waidn: waidn,
                                evidn: evidn
                            },
                            success: function (data) {
                                swal("Action Taken", data, "success").then(function () {
                                    // location.reload();
                                });
                            }

                        });
                    }
                });
            }

        });

        /*
                $('#inputActionField').on('keypress', function(){
                    var query = $("#inputActionField").val();
                    var data  = "query=" + query;

                    var keycode = (event.keyCode ? event.keyCode : event.which);
                    // $("#EventLoadingMessageAudio").show();
                    if(keycode == '13') {

                    $.ajax({
                        url: "otherAction.php",
                        method: "POST",
                        data: {
                            data: data,
                            waidn: waidn,
                            evidn: evidn
                        },
                        success: function (data) {
                            swal("Action Taken", data, "success").then(function () {
                                // location.reload();
                            });
                        }

                    })

                });



=======================================================================================
        $('#queryAudio').on('keypress', function(){
            var query = $("#queryAudio").val();
            var data  = "query=" + query;

            var keycode = (event.keyCode ? event.keyCode : event.which);
            // $("#EventLoadingMessageAudio").show();
            if(keycode == '13') {

                $.ajax({

                    method: "POST",
                    url: "searchAudioButtonListStaff.php",
                    data: data,
                    // beforeSend: function(){
                    //     $('#EventLoadingMessage').show();
                    // },
                    success: function (data) {
                        $("#tableAudioStaff").html(data);
                        $('#listOfAudioHistory tbody').empty();  //empty the table
                        // $('#EventLoadingMessage').fadeOut("slow");
                    },
                    // complete:function(data){
                    //     // Hide image container
                    //     $('#EventLoadingMessage').fadeOut("slow");
                    // },
                });
            }
        });
================================================================================================*/

    });

// Selecting employee
    $('.reportSelected').change(function () {
        if ($(this).val() != '') {
            var reportSelected = $(this).attr("id");
            var query = $(this).val();
            var branchSet = '';

            if(reportSelected == "branch") {
                branchSet = 'employeeList';
            }else{

            }

            $.ajax({
                url:"table_report.php",
                method: "POST",
                data: {
                    reportSelected: reportSelected,
                    query:query
                },
                success: function (data) {
                    $('#' + branchSet).html(data);
                }
            })
        }

    })



    // $.datepicker.setDefaults({
    //     dateFormat: 'yy-mm-dd'
    // });

    $(function() {
        $("#from_date").datepicker({ dateFormat: "yy-mm-dd" }).val();
        $("#to_date").datepicker({ dateFormat: "yy-mm-dd" }).val();
    });

    $('#filter').click(function(e){
        e.preventDefault();

        var from_date = $("#from_date").datepicker({ dateFormat: "yy-mm-dd" }).val();
        var to_date = $("#to_date").datepicker({ dateFormat: "yy-mm-dd" }).val();
        var br = $('#branch').val();
        var empl = $('#employeeList').val();

        console.log(br);
        console.log(empl);
        console.log(from_date);
        console.log(to_date);


       // $(".loader").show();

        if(from_date != '' && to_date != '')
        {
            $.ajax({
                url:"filter.php",
                method:"POST",
                data:{
                    from_date: from_date,
                    to_date: to_date,
                    br: br,
                    empl: empl
                },
                beforeSend: function(){
                    $("#EventLoadingMessage").show();
                },
                success:function(data)
                {
                    $('#reportUpdates').html(data);
                    $('#pagination_controls').hide();
                    // $(".loader").hide();

                },
                complete:function(data){
                    // Hide image container
                    $("#EventLoadingMessage").hide();
                },
            });
        }
        else
        {
            alert("Please Select Date");
        }
    });




    /*search staff with Audio after clicking Audio Acrhive icon  */
    load_all_audio_history();
    function load_all_audio_history(query) {
        console.log(query);
        // $(".loader").show();
        $.ajax({
            url:"listAllEmployeeWithAudio.php",
            method: "POST",
            data:{
                query:query
            },
            beforeSend: function(){
                $("#EventLoadingMessage").show();
            },
            success: function (data) {
                $('#tableAudioStaff').html(data);
                // $("#EventLoadingMessage").fadeOut("slow");
            },
            complete:function(data){
                // Hide image container
                $("#EventLoadingMessage").hide();
            },
        });
    }



    /*search staff audio when pressing the Search button  */
    $('#searchAudio').click(function () {
        var query = $("#queryAudio").val();
        var data  = "query=" + query;
       // $('#EventLoadingMessageAudio').show();
        $.ajax({
            method: "POST",
            url: "searchAudioButtonListStaff.php",
            data: data,
            // beforeSend: function(){
            //     $('#EventLoadingMessage').show();
            // },
            success: function (data) {
                // $('#listOfAudioHistory').html('');
                $("#tableAudioStaff").html(data);
                $('#listOfAudioHistory tbody').empty();  //empty the table
                //$('#EventLoadingMessage').fadeOut("slow");
            },
            // complete:function(data){
            //     // Hide image container
            //     $('#EventLoadingMessage').fadeout("slow");
            // },
        });
    });

    /*search staff audio when pressing Enter Key from Keyboard */
    $('#queryAudio').on('keypress', function(){
        var query = $("#queryAudio").val();
        var data  = "query=" + query;

        var keycode = (event.keyCode ? event.keyCode : event.which);
       // $("#EventLoadingMessageAudio").show();
        if(keycode == '13') {

            $.ajax({

                method: "POST",
                url: "searchAudioButtonListStaff.php",
                data: data,
                // beforeSend: function(){
                //     $('#EventLoadingMessage').show();
                // },
                success: function (data) {
                    $("#tableAudioStaff").html(data);
                     $('#listOfAudioHistory tbody').empty();  //empty the table
                  // $('#EventLoadingMessage').fadeOut("slow");
                },
                // complete:function(data){
                //     // Hide image container
                //     $('#EventLoadingMessage').fadeOut("slow");
                // },
            });
        }
    });



    $(document).on('click', '#audioStaffTableRowItem', function(){

        $('#selected').removeClass('selected');
        $(this).addClass("selected");
        var waidn = $(this).find(".waidn").html();
        console.log(waidn);
       // $("#EventLoadingMessageAudio").show();

        $.ajax({
            type: "POST",
            url:"audioEmp.php",
            data: {
                waidn: waidn
            },
            success: function (data) {
                $('#listOfAudioHistory').html(data);
                $("#EventLoadingMessageAudio").fadeOut();
            }
        });
        // $.post('audioEmp.php', {waidn: waidn}, function(data){
        //     $('#listOfAudioHistory').html(data);
        //    // $('#EventLoadingMessageAudio').fadeOut("slow");
        //
        // });
    });


});
