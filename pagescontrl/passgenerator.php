<div id="signin-form">
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                
                
                <form 
                    action=""
                    method="POST"
                    class="form-signin">
                    <div  class="form-group has-success">
                        <input 
                        type="password" 
                        class="form-control"
                        name="inpass"
                        id="inpass"
                        placeholder="Password"
                        required>
                    </div>
                    <input type="hidden" name="dohash" value="true"/>
                    <button
                        class="btn btn-sm btn-success btn-block"
                        type="submit">
                        Generate</button>
                    <hr>
                    <br>
                </form>
                <div>
                    <center>
                        <h5>
                        <?php
                        if(isset($_POST["dohash"])){
                            require_once '../server/cryptpass.php';
                            echo encrypt_pass($_POST["inpass"]);
                        }
                        ?>
                        </h5>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
