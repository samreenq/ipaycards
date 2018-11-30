<!-- recent orders table -->
<div class="panel panel-theme panel-border top mb25">
    <div class="panel-heading">
        <span class="panel-title">Listing</span>
        <span class="panel-controls">
					@if(!empty($delete_permission) && $delete_permission == 1)
                <a class="select_action" title="delete">
								<button type="button" class="btn-default btn-sm link-unstyled ib" ><span class="icon mdi mdi-delete pr5 fs15"></span> Delete</button>
							</a>
            @endif
          @if($uri_method != 'view')
            @if(in_array($entity_data->identifier,$allow_export))
                <a class="export_entity hide" title="export">
								<button type="button" class="btn-default btn-sm link-unstyled ib" ><span class="icon mdi mdi-export pr5 fs15"></span>Export to Excel</button>
							</a>
            @endif

            @if(in_array($entity_data->identifier,$allow_import))
                <a class="" title="Import" href="{!! URL::to($panel_path.$module.'/import') !!}">
								<button type="button" class="btn-default btn-sm link-unstyled ib" ><span class="icon mdi mdi-export pr5 fs15"></span>Import</button>
							</a>
            @endif
                        @endif
					</span>
    </div>

    <div class="panel-body pn">
        <form name="listing_form" method="post">
            <section id="content" class="pn table-layout">
                <div class="tray pn">
                    <div class="panel">
                        <div class="table-responsive">

                            <table class="table table-hover responsive fs13 smallTable smallImgTable" id="mydatatable" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <?php  foreach ($columns as $column_field) { ?>
                                    <th><?=  $column_field ?></th>
                                    <?php } ?>
                                </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </section>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
        </form>
    </div>
</div>