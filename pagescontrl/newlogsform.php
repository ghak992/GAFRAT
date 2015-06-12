<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>New Log</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="new-log-form" role="form">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Log Type</label>
                            <div class="col-sm-10">
                                <select class="form-control"
                                        id="new-log-form-type"
                                        name="new-log-form-type"
                                        >
                                    <option value="1000" selected="false">  </option>
                                    <?php
                                    foreach (DBoperations::getLogsTypes() as $key => $value) {
                                        ?>
                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Log Title</label>
                            <div class="col-sm-10">
                                <input type="text" 
                                       id="new-log-form-title"
                                       name="new-log-form-title"
                                       placeholder="title .."
                                        required=""
                                       class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Solve By</label>
                            <div class="col-sm-10">
                                <input type="text" 
                                       id="new-log-form-solve-by"
                                       name="new-log-form-solve-by"
                                       placeholder="solve by .."
                                        required=""
                                       class="form-control">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Description</label>
                            <div class="col-sm-10">
                                <textarea 
                                    placeholder="description .."
                                    required=""
                                    class="form-control"
                                    rows="5"
                                    id="new-log-form-desc"
                                    name="new-log-form-desc"
                                    ></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="textinput">Description</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                 <input 
                                    class="form-control"
                                    name="file[]" 
                                    type="file" 
                                    id="file"/>
                                <input type="button"
                                       class="form-control btn btn-default"
                                       id="add_more"
                                       class="upload"
                                       value="Add More Image"/>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="destination" id="destination" value="newlog"/>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="pull-left">
                                    <div id="new-log-form-message"></div>
                                </div>
                                <div class="pull-right">
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </div>
                        
                    </fieldset>
                </form>
            </div>

        </div>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->