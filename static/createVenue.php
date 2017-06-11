<?php
//<body class="sfooter">
//<div class="sfooter-content">

//<!-- insert header and navbar -->
//<?php require_once("lib/header.php");?>

<html>
<body>

<main class="bg">
    <div class="container">
        <div class="row">

            <div class="col-md-4">
                <h1>Create Venue</h1>

                <!-- Create New Post Form -->
                <form id="create-venue">
                    <div class="form-group">
                        <label class="sr-only" for="venueName">Venue Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </div>
                            <input type="text" class="form-control" id="venueName" name="venueName"
                                   placeholder="Venue Name">
                        </div>
                    </div>

                    <form id="create-venue">
                        <div class="form-group">
                            <label class="sr-only" for="venueAddress">Venue Address 1 <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </div>
                                <input type="text" class="form-control" id="venueAddress" name="venueAddress"
                                       placeholder="Venue Address">
                            </div>
                        </div>

                        <form id="create-venue">
                            <div class="form-group">
                                <label class="sr-only" for="venueAddress2">Venue Address 2 <span
                                            class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </div>
                                    <input type="text" class="form-control" id="venueAddress2" name="venueAddress2"
                                           placeholder="Venue Address 2">
                                </div>
                            </div>


                            <form id="create-venue">
                                <div class="form-group">
                                    <label class="sr-only" for="venueCity"> Venue City<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" class="form-control" id="venueCity" name="venueCity"
                                               placeholder="Venue City">
                                    </div>
                                </div>

                                <form id="create-venue">
                                    <div class="form-group">
                                        <label class="sr-only" for="venueEmail">Venue Email <span
                                                    class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" class="form-control" id="venueEmail" name="venueEmail"
                                                   placeholder="Venue Email">
                                        </div>
                                    </div>

                                    <form id="create-venue">
                                        <div class="form-group">
                                            <label class="sr-only" for="venueState">Venue State <span
                                                        class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </div>
                                                <input type="text" class="form-control" id="venueState"
                                                       name="venueState" placeholder="Venue State">
                                            </div>
                                        </div>

                                        <form id="create-venue">
                                            <div class="form-group">
                                                <label class="sr-only" for="venueZip">Venue Zip <span
                                                            class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="venueZip"
                                                           name="venueZip" placeholder="Venue Zip">
                                                </div>
                                            </div>

                                            <form id="create-venue">
                                                <div class="form-group">
                                                    <label class="sr-only" for="venueContent">Venue Content <span
                                                                class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="venueContent"
                                                               name="venueContent" placeholder="venueContent">
                                                    </div>
                                                </div>

                                                <form id="create-venue">
                                                    <div class="form-group">
                                                        <label class="sr-only" for="profilePassword">Venue Password <span
                                                                    class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                                            </div>
                                                            <input type="text" class="form-control" id="profilePassword"
                                                                   name="profilePassword" placeholder="venue password">
                                                        </div>
                                                    </div>

                                                    <form id="create-venue">
                                                        <div class="form-group">
                                                            <label class="sr-only" for="profileConfirmPassword">Confirm Password <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <div class="input-group-addon">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </div>
                                                                <input type="text" class="form-control" id="profileConfirmPassword" name="profileConfirmPassword" placeholder="re-type password">
                                                            </div>
                                                        </div>

                                                    <button class="btn btn-success" type="submit"><i
                                                                class="fa fa-paper-plane"></i> Submit
                                                    </button>
                                                    <button class="btn btn-warning" type="reset"><i
                                                                class="fa fa-ban"></i> Reset
                                                    </button>
                                                </form>

            </div>

</body>
</html>