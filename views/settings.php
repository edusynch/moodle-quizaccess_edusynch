<div class="container">
<?php 
$host = $PAGE->url->get_host();
?>

    <div class="tab-content">

        <?php if ($success): ?>
        <div class="alert alert-success">Success!</div>
        <?php endif; ?>

        <div class="tab-pane fade show active" id="nav-settings" role="tabpanel">
            <h4 class="mt-3">Keys</h4>

            <form action="<?php echo EPROCTORING_URL  ?>?action=settings" method="POST" class="mt-3">
                <?php if ($host == 'localhost' || strpos($host, 'edusynch.com') !== FALSE): ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">Student API: </label>
                            <input class="form-control" type="text" id="student_api" name="student_api" value="<?php echo $student_api_value ? $student_api_value : 'https://api.edusynch.com' ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="api_key">CMS API: </label>
                            <input class="form-control" type="text" id="cms_api" name="cms_api" value="<?php echo $cms_api_value ? $cms_api_value : 'https://cmsapi.edusynch.com' ?>">
                        </div>
                    </div>
                </div>                
                <?php endif; ?>

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

            <hr>            
            <h4 class="mt-3">Import students</h4>

            <div class="row">
              <div class="col-md-12">
                    Use the box below to import a .CSV file with your students data, like <a href="<?php echo EPROCTORING_PATH ?>students-import.csv">this example</a>

                    <br> 
                    <?php echo $importform->render() ?>
              </div>
            </div>

            </form>

        </div>

    </div>
</div>