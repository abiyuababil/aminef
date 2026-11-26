<div class="panel-body">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel-group" id="accordion<?= $up->id ?>">
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseApplication<?= $up->id ?>" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseApplication<?= $up->id ?>">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Application</h4> 
                    </div>
                    <div id="collapseApplication<?= $up->id ?>" class="panel-collapse collapse">
                        <ul class="list-group">

                        <li class="list-group-item" id="accordion<?= $up->id ?>">
                            <a class="btn-section" data-section="application" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>" href="#" target="_blank">Application</a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseSelection<?= $up->id ?>" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseSelection<?= $up->id ?>" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Selection</h4>
                    </div>
                    <div id="collapseSelection<?= $up->id ?>" class="panel-collapse collapse">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a class="btn-section" data-section="validation" href="#" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Validation</a>
                            </li>
                            <li class="list-group-item">
                                <a class="btn-section" data-section="review" href="#" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Selection Review</a>
                            </li>
                            <li class="list-group-item">
                                <a class="btn-section" data-section="interview" href="#" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Selection Interview</a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseNominee<?= $up->id ?>" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseNominee<?= $up->id ?>">
                            <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Nominee</h4>
                    </div>

                    <div id="collapseNominee<?= $up->id ?>" class="panel-collapse collapse">
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
                                    $collapseId = "collapse_".$parentSlug.$up->id;
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
                                                    <li class="list-group-item ml-4" id="accordion<?= $up->id ?>">
                                                        <a class="btn-section ml-4" data-section="nominee" data-sub_section="<?= str_replace('-', '_', str_slug($menu_nominee_master[$childKey]['label'])) ?>" href="#" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>"><?= $menu_nominee_master[$childKey]['label'] == 'Placement' ? 'Final Placement' : $menu_nominee_master[$childKey]['label'] ?></a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>

                                <?php else: ?>
                                    <!-- No children -->
                                    <li class="list-group-item ml-5" id="accordion<?= $up->id ?>">
                                        <a class="btn-section"
                                        data-section="nominee"
                                        data-sub_section="<?= str_replace('-', '_', str_slug($parentData['label'])) ?>"
                                        data-grantee_grant_id="<?= $up->grantee_grant_id ?>"
                                        data-up="<?= $up->id ?>"
                                        href="#">
                                            <?= $parentData['label'] ?>
                                        </a>
                                    </li>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseOngoing<?= $up->id ?>" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseOngoing<?= $up->id ?>" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">On Going</h4>
                    </div>
                    <div id="collapseOngoing<?= $up->id ?>" class="panel-collapse collapse">
                        <ul class="list-group">

                        <li class="list-group-item" id="accordion<?= $up->id ?>">
                            <a class="btn-section" href="#" target="_blank" data-section="ongoing" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">On Going</a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseReturning<?= $up->id ?>" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseReturning<?= $up->id ?>" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Returning</h4>
                    </div>
                    <div id="collapseReturning<?= $up->id ?>" class="panel-collapse collapse">
                        <ul class="list-group">

                        <li class="list-group-item" id="accordion<?= $up->id ?>">
                            <a class="btn-section" href="#" target="_blank" data-section="returning" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Returning</a>
                        </li>
                        </ul>
                    </div>
                </div>

                <div class="panel panel-primary">
                    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseGrantSupport<?= $up->id ?>" style="cursor: pointer;">
                        <a class="collapsed pull-right" data-toggle="collapse" data-parent="#accordion<?= $up->id ?>" href="#collapseGrantSupport<?= $up->id ?>" style="cursor: pointer;">
                        <div class="accordion-icon"></div>
                        </a>
                        <h4 class="panel-title">Grant Support</h4>
                    </div>
                    <div id="collapseGrantSupport<?= $up->id ?>" class="panel-collapse collapse">
                        <ul class="list-group">

                            <li class="list-group-item" id="accordion<?= $up->id ?>">
                                <a class="btn-section" href="#" target="_blank" data-section="visa" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Visa</a>
                            </li>
                            <li class="list-group-item" id="accordion<?= $up->id ?>">
                                <a class="btn-section" href="#" target="_blank" data-section="travel_arrangement" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Travel Arrangement</a>
                            </li>
                            <li class="list-group-item" id="accordion<?= $up->id ?>">
                                <a class="btn-section" href="#" target="_blank" data-section="allowance" data-grantee_grant_id="<?= $up->grantee_grant_id ?>" data-up="<?= $up->id ?>">Allowance</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-sm-9 html-section<?= $up->id ?>">
            <div class="alert alert-info text-center hide" id="loading-spinner<?= $up->id ?>"><i class="fa fa-spinner fa-spin"></i> Loading, please wait.</div>
        </div>
    </div>
</div>