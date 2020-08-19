<div class="container-fluid">

    <div class="row p-5">
        <div class="col-md-12">
            <h1>Image Checker</h1>

            <p>Please enter the size of the images you want to sort in pixels. <em>Recommended to start with 400px by
                    400px.</em></p>

            <?php if (@$this->imageResultsSuccess) echo "<div class='alert alert-success'>" . $this->imageResultsSuccess . "</div>"; ?>
            <?php if (@$this->imageResultsFailure) echo "<div class='alert alert-danger'>" . $this->imageResultsFailure . "</div>"; ?>

            <div class="row">
                <div class="col-md-6">
                    <form action="<?php echo base_url . to_url("imagechecker/runChecker") ?>" method="post">

                        <div class="form-group">

                            <label for="exampleInputEmail1">Maximum width (pixels):</label>

                            <input type="number" name="maxWidth" class="form-control"
                                   value="<?php echo @$_POST['maxWidth']; ?>" required placeholder="400"/>

                        </div>

                        <div class="form-group">

                            <label for="exampleInputEmail1">Maximum height (pixels):</label>

                            <input type="number" name="maxHeight" class="form-control"
                                   value="<?php echo @$_POST['maxHeight']; ?>" required placeholder="400"/>

                        </div>

                        <button type="submit" value="Update" class="btn btn-primary">Submit</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if (@$this->pictureMSGFailure) echo "<div class='alert alert-danger'>" . $this->pictureMSGFailure . "</div>"; ?>
    <?php if (@$this->pictureMSGSuccess) echo "<div class='alert alert-success'>" . $this->pictureMSGSuccess . "</div>"; ?>

    <?php if (@$this->corruptFailure) { ?>
        <div class="row px-5">
            <div class="col-xs-12 col-md-8">
                <?
                $corruptImages = $this->corruptFailure;
                echo "<h3>" . count($corruptImages) . " Corrupted/Missing images Found</h3>";
                ?>
                <ul class="list-group">
                    <? foreach ($corruptImages as $image) { ?>
                        <li class='list-group-item mb-3'>
                        <form action="<?php echo base_url . to_url("imagechecker/updateRecord") ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" id="sku" name="sku" value="<?php echo $image['sku'] ?>"/>
                            <input type="hidden" id="fileName" name="fileName" value="<?php echo $image['fileName'] ?>"/>
                            <input type="hidden" name="maxHeight" class="form-control" value="<?php echo @$_POST['maxHeight']; ?>"/>
                            <input type="hidden" name="maxWidth" class="form-control" value="<?php echo @$_POST['maxWidth']; ?>"/>
                            <? echo "<strong>Product SKU:</strong> " . $image["sku"] . "<br /><strong>Image File:</strong> " . base_url . "images/" . $image["fileName"]; ?>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type='file' class="custom-file-input" id='newImage' name='newImage'/>
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                            </div>
                            <button type='submit' class='btn btn-primary btn-sm text-uppercase' id='update' name='update' value='update'>Update</button>
                            <button type='submit' class='btn btn-danger text-uppercase btn-sm' value='delete'>Delete</button>
                        </form>
                        </li>
                    <? } ?>
                </ul>
            </div>
        </div>
    <? } ?>


    <?php if (@$this->imageResults) {
        ?>
        <div class="row p-5">
            <?
            $resultImages = $this->imageResults;
            echo "<h3>" . count($resultImages) . " Images found under size requirement</h3>";
            ?>
            <div class="row py-2">
                <?
                foreach ($resultImages as $image) {
                    ?>
                    <div class='col-xs-4 col-md-2 py-2'>
                        <div class="content-thumbnail-container border border-danger rounded">
                            <div class="image-thumbnail-container">
                                <?
                                echo "<img src='" . base_url . "images/" . $image["fileName"] . "' class='image-thumbnail img-fluid' alt='Howetools - Product SKU:" . $image["sku"] . "' />";
                                ?>
                            </div>
                            <div class="p-2">
                                <?
                                echo "<strong>Product SKU:</strong> " . $image["sku"] . "<br >";
                                echo "<strong>Image Type:</strong> " . $image["type"] . "<br >";
                                ?>
                            </div>
                            <div class="row">
                                <form action="<?php echo base_url . to_url("imagechecker/updateRecord") ?>"
                                      method="post" enctype="multipart/form-data">
                                    <input type="hidden" id="sku" name="sku" value="<?php echo $image['sku'] ?>"/>
                                    <input type="hidden" id="fileName" name="fileName"
                                           value="<?php echo $image['fileName'] ?>"/>
                                    <input type="hidden" name="maxHeight" class="form-control"
                                           value="<?php echo @$_POST['maxHeight']; ?>"/>
                                    <input type="hidden" name="maxWidth" class="form-control"
                                           value="<?php echo @$_POST['maxWidth']; ?>"/>

                                    <div class="col-xs-12 col-sm-12">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type='file' class="custom-file-input" id='newImage'
                                                       name='newImage'/>
                                                <label class="custom-file-label" for="inputGroupFile01">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <button type='submit' class='mb-2 btn-block btn btn-primary btn-sm text-uppercase'
                                                id='update' name='update' value='update'>Update
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-sm-12">
                                        <button type='submit' class='btn-block btn btn-danger text-uppercase btn-sm'
                                                value='delete'>Delete
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                <? } ?>
            </div>
        </div>
    <? } ?>

</div>

</div>
