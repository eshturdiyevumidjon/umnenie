<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="error-container">

    <div class="error-code">404</div>

    <div class="error-text">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <div class="error-subtext">
        The above error occurred while the Web server was processing your request.

        Please contact us if you think this is a server error. Thank you.
    </div>

    <div class="error-actions">                                
        <div class="row">
            <div class="col-md-6">
               <button class="btn btn-info btn-block btn-lg" onClick="document.location.href = '/';">Back to dashboard</button>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary btn-block btn-lg" onClick="history.back();">Previous page</button>
            </div>
        </div>                                                             
     </div>                            
         <!-- <div class="error-subtext">Or you can use search to find anything you need.</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                 <input type="text" placeholder="Search..." class="form-control"/>
                                 <div class="input-group-btn">
                                    <button class="btn btn-primary"><span class="fa fa-search"></span></button>
                                </div>
                            </div>
                        </div>
                    </div> -->

</div>
