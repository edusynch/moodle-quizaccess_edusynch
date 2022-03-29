<div class="container">
    <div class="tab-content">

        <?php if ($success): ?>
        <div class="alert alert-success">Success!</div>
        <?php endif; ?>

        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel">

            <form action="<?php echo $CFG->wwwroot ?>/mod/quiz/accessrule/edusyncheproctoring/index.php?action=settings" method="POST" class="mt-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">API Key: </label>
                            <input class="form-control" type="text" id="api_key" name="api_key" value="<?php echo $api_key_value ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="user">User: </label>
                            <input class="form-control" type="text" id="user" name="user" value="<?php echo $user_value ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Password: </label>
                            <input class="form-control" type="password" id="password" name="password" value="<?php echo $password_value ?>">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>

        </div>

    </div>
</div>