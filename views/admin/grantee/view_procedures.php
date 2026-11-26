
<div class="row">
    <div class="col-lg-12">
        <h1><?= get_full_name($grantee_grant) ?></h1>
        <h3 class="page-header"><?= $grantee_grant->grant_name ?> (<?= $grantee_grant->fiscal_year_period ?>)</h3>
    </div>
</div>



<div class="panel-body">
    <div class="row">
        <div class="col-sm-3">
            
            <!-- <ul class="list-group">
                <li class="list-group-item">
                    <a class="btn-section" data-section="application" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="" href="#" target="_blank">Application</a>
                </li>
                <li class="list-group-item">
                    <a class="btn-section pleft" data-section="validation" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Validation</a>
                </li>
                <li class="list-group-item">
                    <a class="btn-section pleft" data-section="review" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Selection Review</a>
                </li>
                <li class="list-group-item">
                    <a class="btn-section pleft" data-section="interview" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Selection Interview</a>
                </li>
                <?php 
                    if(empty($menu_section)){
                        $menu_section = array_keys($menu_nominee_master);
                    }
                    foreach($menu_section as $ms) :
                    if($ms == 'tnc'){ continue; } 
                    $slugNominee = $menu_nominee_master[$ms]['label'] ? str_replace('-', '_', str_slug($menu_nominee_master[$ms]['label'])) : '';
                    
                ?>
                    <li class="list-group-item">
                        <a class="btn-section" data-section="nominee" data-sub_section="<?= $slugNominee ?>" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up=""><?= $menu_nominee_master[$ms]['label'] == 'Placement' ? 'Final Placement' : $menu_nominee_master[$ms]['label'] ?></a>
                    </li>
                <?php endforeach; ?>

                <li class="list-group-item">
                    <a class="btn-section" href="#" target="_blank" data-section="ongoing" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">On Going</a>
                </li>
                <li class="list-group-item">
                    <a class="btn-section" href="#" target="_blank" data-section="returning" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Returning</a>
                </li>
            </ul> -->


            <div class="panel-group" id="accordionParent">
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordionParent" href="#collapseApplication" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordionParent" href="#collapseApplication">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Application</h4>
                    </div>
                    <div id="collapseApplication" class="panel-collapse collapse">
                        <ul class="list-group">

                        <li class="list-group-item">
                            <a class="btn-section" data-section="application" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="" href="#" target="_blank">Application</a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordionParent" href="#collapseSelection" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordionParent" href="#collapseSelection" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Selection</h4>
                    </div>
                    <div id="collapseSelection" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a class="btn-section" data-section="validation" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Validation</a>
                            </li>
                            <li class="list-group-item">
                                <a class="btn-section" data-section="review" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Selection Review</a>
                            </li>
                            <li class="list-group-item">
                                <a class="btn-section" data-section="interview" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Selection Interview</a>
                            </li>
                        </ul>
                    </div>
                </div>



                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordionParent" href="#collapseNominee" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordionParent" href="#collapseNominee">
                            <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Nominee</h4>
                    </div>

                    <div id="collapseNominee" class="panel-collapse collapse">
                        <ul class="list-group">
                            <?php 
                            $nominee_structure = [
                                'pre_placement' => [
                                    'label' => 'Pre-Placement',
                                    'children' => [
                                        'mentoring',
                                        'test_preparation',
                                        'test_section',
                                    ]
                                ],
                                'placement' => [
                                    'label' => 'Placement',
                                    'children' => [
                                        'submission_plan',
                                        'direct_application',
                                        'submission_result',
                                        'placement',
                                    ]
                                ],
                                'pre_departure_orientation' => [
                                    'label' => 'Pre Departure Orientation',
                                    'children' => []
                                ],
                                'departure' => [
                                    'label' => 'Departure',
                                    'children' => []
                                ],
                            ];

                            
                            foreach ($nominee_structure as $parentKey => $parentData): ?>

                                <?php  
                                    
                                    $parentSlug = str_slug($parentData['label']);
                                    $collapseId = "collapse_".$parentSlug;
                                ?>

                                <?php if (!empty($parentData['children'])): ?>
                                    
                                    <div class="panel panel-primary mt-2 ml-4">
                                        <div class="panel-heading" data-toggle="collapse" data-parent="#accordionParentsss" href="#<?= $collapseId ?>" style="cursor: pointer;">
                                            <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordionParentsss" href="#<?= $collapseId ?>" style="cursor: pointer;">
                                            <div class="accordion-icon"></div>
                                            </a>
                                            <h4 class="panel-title ml-4"> <?= $parentData['label'] ?></h4>
                                        </div>
                                        <div id="<?= $collapseId ?>" class="panel-collapse collapse">
                                            <ul class="list-group">
                                                <?php foreach ($parentData['children'] as $childKey):    
                                                ?>
                                                    <li class="list-group-item ml-4">
                                                        <a class="btn-section ml-4" data-section="nominee" data-sub_section="<?= str_replace('-', '_', str_slug($menu_nominee_master[$childKey]['label'])) ?>" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up=""><?= $menu_nominee_master[$childKey]['label'] == 'Placement' ? 'Final Placement' : $menu_nominee_master[$childKey]['label'] ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <!-- No children -->
                                    <li class="list-group-item ml-5">
                                        <a class="btn-section"
                                        data-section="nominee"
                                        data-sub_section="<?= str_replace('-', '_', str_slug($parentData['label'])) ?>"
                                        data-grantee_grant_id="<?= $grantee_grant_id ?>"
                                        href="#">
                                            <?= $parentData['label'] ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary hidden">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordionParent" href="#collapseNominee2"  style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordionParent" href="#collapseNominee2"  style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Nominee</h4>
                    </div>
                    <div id="collapseNominee2" class="panel-collapse collapse">
                        <ul class="list-group">
                            <?php 
                                // $menu_section = $up->nominee_menu ? explode(",", $up->nominee_menu) : [];
                                if(empty($menu_section)){
                                    $menu_section = array_keys($menu_nominee_master);
                                }
                                foreach($menu_section as $ms) :
                                if($ms == 'tnc' || $ms == 'eec' || $ms == 'fsb' || $ms == 'other_documents'){ continue; } 
                                $slugNominee = $menu_nominee_master[$ms]['label'] ? str_replace('-', '_', str_slug($menu_nominee_master[$ms]['label'])) : '';
                                
                            ?>
                                <li class="list-group-item">
                                    <a class="btn-section" data-section="nominee" data-sub_section="<?= $slugNominee ?>" href="#" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up=""><?= $menu_nominee_master[$ms]['label'] == 'Placement' ? 'Final Placement' : $menu_nominee_master[$ms]['label'] ?></a>
                                </li>
                            <?php endforeach; ?>

                        <!-- <li class="list-group-item">
                            <a class="btn-section" data-section="nominee" href="<?= base_url('admin/application/verify/')?>" target="_blank">Application</a>
                        </li> -->
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordionParent" href="#collapseOngoing" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordionParent" href="#collapseOngoing" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Ongoing</h4>
                    </div>
                    <div id="collapseOngoing" class="panel-collapse collapse">
                        <ul class="list-group">

                        <li class="list-group-item">
                            <a class="btn-section" href="#" target="_blank" data-section="ongoing" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Ongoing</a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseReturning" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapseReturning" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Returning</h4>
                    </div>
                    <div id="collapseReturning" class="panel-collapse collapse">
                        <ul class="list-group">

                        <li class="list-group-item">
                            <a class="btn-section" href="#" target="_blank" data-section="returning" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Returning</a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapseGrantSupport" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapseGrantSupport" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Grant Support</h4>
                    </div>
                    <div id="collapseGrantSupport" class="panel-collapse collapse">
                        <ul class="list-group">

                            <li class="list-group-item" id="accordion">
                                <a class="btn-section" href="#" target="_blank" data-section="visa" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Visa</a>
                            </li>
                            <li class="list-group-item" id="accordion">
                                <a class="btn-section" href="#" target="_blank" data-section="travel_arrangement" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Travel Arrangement</a>
                            </li>
                            <li class="list-group-item" id="accordion">
                                <a class="btn-section" href="#" target="_blank" data-section="allowance" data-grantee_grant_id="<?= $grantee_grant_id ?>" data-up="">Allowance</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>


        </div>

        <div class="col-sm-9 html-section">
            <div class="alert alert-info text-center hide" id="loading-spinner"><i class="fa fa-spinner fa-spin"></i> Loading, please wait.</div>
        </div>
    </div>
</div>