<div class="flyout-overlay"></div>
<div class="fly-nav-inner">
    <div class="container">
        <button class="dropdown-toggle" data-toggle="dropdown">Collection <span
                    class="glyphicon glyphicon-chevron-down pull-right"></span></button>
        <div class="dropdown-menu mega-dropdown-menu">
            <ul class="row">
                <li class="col-sm-12">
                    <ul class="nav sidebar__inner" role="tablist">

                        <?php

                        foreach($type as $attributes)
                        {
                        ?>
                        <li class="li-active" role="presentation"><a href="#general" class="active"
                                                                     data-toggle="tab"><?php echo $attributes->option; ?></a>
                        </li>

                        <?php
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="faq-left-bar col-md-12 col-lg-3 col-xl-2">
            <div id="sidebar">
                <ul class="nav sidebar__inner" role="tablist">

                    <?php
                    $a = 1;
                 //   echo "<pre>";  print_r($type); exit;
                    foreach($type as $attributes)
                    {
                    ?>
                    <li role="presentation"><a
                            <?php if ($a == 1) echo 'class="active" aria-expanded="true"';?> href="#a<?php echo $attributes->value; ?>"
                            data-toggle="tab"><?php echo $attributes->option; ?></a></li>

                    <?php
                    $a++;
                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="faq-right-bar col-md-12 col-lg-9 col-xl-10">
            <!-- Tab panes -->
            <div class="tab-content">

                <?php
                $a = 1;
                foreach($type as $type_attributes)
                {
                ?>


                <div role="tabpanel"
                     <?php if ($a == 1) echo 'class=" tab-pane active" aria-expanded="true"'; else echo 'class="tab-pane"';?>     id="a<?php echo $type_attributes->value; ?>">
                    <div class="faq-right-header">
                        <h4><?php echo $type_attributes->option ?></h4>
                    </div>
                    <div class="faq-right-accord">
                        <div class="panel-group" id="generalaccordion<?php echo $type_attributes->value; ?>">


                            <?php
                            $j = 0;
                            foreach ( $frequentAskedQuestions as $frequentAskedQuestions_attribute )
                            {
                            if($frequentAskedQuestions_attribute['attributes']['type']['value'] == $type_attributes->value )
                            {

                            ?>
                            <div class="faq-panel panel">
                                <div class="faq-accord-heading">
                                    <a data-toggle="collapse"
                                       data-parent="#generalaccordion<?php echo $type_attributes->value; ?>"
                                       class="collapsed"
                                       href="#generalcollapse<?php echo $frequentAskedQuestions_attribute['entity_id']; ?>"><?php echo $frequentAskedQuestions_attribute['attributes']['title']; ?></a>
                                </div>
                                <div id="generalcollapse<?php echo $frequentAskedQuestions_attribute['entity_id']; ?>"
                                     class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p><?php echo $frequentAskedQuestions_attribute['attributes']['description']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            $j++;
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <?php
                $a++;
                }
                ?>


            </div>
        </div>
    </div>
</div>