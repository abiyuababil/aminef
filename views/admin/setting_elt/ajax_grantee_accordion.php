<div 
    class="panel-group grantee-panel" 
    id="grantee_<?= $term['term_id'] ?>"
    data-term="<?= $term['term_id'] ?>"
    id="accordion_<?= $term['term_id'] ?>" 
    role="tablist" 
    aria-multiselectable="true"
>
    <div class="panel panel-default">
        <a role="button" data-toggle="collapse" data-parent="#accordion_<?= $term['term_id'] ?>" href="#collapse_<?= $term['term_id'] ?>" aria-expanded="true" aria-controls="collapse_<?= $term['term_id'] ?>">
            <div class="panel-heading panel-heading-departure text-left" role="tab" id="<?= $key ?>">
                <h4 class="panel-title">
                    <?= $term['term'] ?>
                </h4>
            </div>
        </a>
        <div id="collapse_<?= $term['term_id'] ?>" class="panel-collapse collapse <?= $this->session->userdata('last_list') == 'support_letter' ? 'in' : '' ?>" role="tabpanel" aria-labelledby="<?= $key ?>">
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($term['grantees'] as $g): ?>
                        <tr>
                            <td><?= $g->first_name . ' ' . $g->last_name ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>