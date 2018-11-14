@include(config('panel.DIR').'header')
<!-- Start: Content-Wrapper -->
<section id="content_wrapper" class="content">
  <div id="seaction-header"> @include(config('panel.DIR').'flash_message')
    <div class="adv-search">
      <div class="topbar-left">
        <div class="table-tools"> <a class="select_action" title="delete">
          <button type="button" class="btn-default btn-sm link-unstyled ib" ><span class="icon mdi mdi-delete pr5 fs15"></span> Delete</button>
          </a> 
        </div>
      </div>
      <div class="topbar-right text-right">
        <div class="pull-right adv-search-bar">
          <button type="button" class="accordion-toggle mr5 btn-default btn-sm accordion-icon link-unstyled collapsed ib" data-toggle="collapse" data-parent="#accordion" href="#adv-search"><span class="icon mdi mdi-menu"></span></button>
           <a href="{!! URL::to(config('panel.DIR').$module.'/add') !!}" class="btn-default btn-sm add-new-btn link-unstyled ib"><span class="icon mdi mdi-plus pr5 fs15"></span> Add {!! $module !!}</a> </div>
      </div>
    </div>
    <div id="adv-search" class="panel-collapse collapse" style="height: auto;">
      <div class="panel-body bg-light lighter br-h-n br-t-n search-filters">
        <div class="row">
          <div class="col-md-8">
            <div class="row">
              <div class="col-md-6 multiSelect mb20">
                <label>Filter Column</label>
                <select class="search_columns" id="multiselect2" multiple="multiple" >
                  <option value="slug">Slug</option>
                  <option value="title">Title</option>
                  <option value="created_at">Created At</option>
                  <option value="updated_at">Updated At</option>
                </select>
				<i class="arrow"></i>
              </div>
              <div class="col-md-6 mb5">
                <label>Keyword</label>
                <input type="text" name="keyword" class="form-control" placeholder="Keyword">
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mt25 clearfix">
              <a type="button" id="grid_reset" class="btn btn-default btn-md col-sm-6 mr5 btn-clear">Clear</a>
              <a type="button" id="grid_search" class="btn btn-theme btn-md col-sm-6 btn-search">Search</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form name="listing_form" method="post">
    <!-- End: Topbar -->
    <!-- Begin: Content -->
    <section id="content" class="pn table-layout">
      <div class="tray pn">
        <div class="panel">
          <div class="table-responsive">
            <table class="table table-hover responsive" id="mydatatable" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th> 
                      <div class="checkbox-t">
                         <input type="checkbox" id="check_all" name="check_all" />
                         <label for="check_all"></label>
                     </div>
                 </th>
                  <th>Slug</th>
                  <th>Title</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Options</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </section>
    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
  </form>
  <!-- End: Content -->
  <!-- Begin: Page Footer -->
  @include(config('panel.DIR') . 'footer_bottom')
  <!-- End: Page Footer -->
</section>
<!-- Detailed View Popup -->
<!-- End: Content-Wrapper -->
<!-- Required Plugin CSS -->
<link rel="stylesheet" type="text/css" href="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/datepicker/css/bootstrap-datetimepicker.css' ) !!}">
<link rel="stylesheet" type="text/css" href="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/daterange/daterangepicker.css' ) !!}">
<!-- Page Plugins via CDN -->
<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/moment/moment.min.js' ) !!}"></script>
<!-- Datatables -->
<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/datatables/media/js/datatables.min.js' ) !!}"></script>
<!-- ckeditor -->
<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/ckeditor/ckeditor.js' ) !!}"></script>
<!-- Page Plugins -->
<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/xeditable/js/bootstrap-editable.js' ) !!}"></script>
<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/daterange/daterangepicker.js' ) !!}"></script>
<script src="{!! URL::to(config('panel.DIR_PANEL_RESOURCE') . 'vendor/plugins/datepicker/js/bootstrap-datetimepicker.js' ) !!}"></script>
<script type="text/javascript">
	$(document).ready(function() {	

		// Init Boostrap Multiselect
		$('#multiselect2').multiselect({
			includeSelectAllOption: true
		});
		
		// Init Boostrap Multiselect
		$('#multiselect3').multiselect({
			includeSelectAllOption: true
		});	

        // Init daterange plugin
        $('#daterangepicker1').daterangepicker();

        // Init datetimepicker - fields
        $('#datetimepicker1').datetimepicker();
        
        // Select Status
		if($('a').hasClass('admin-status')){
			$('.admin-status').editable({
				showbuttons: false,
				source: [
					{value: 1, text: 'Active'},
					{value: 2, text: 'Inactive'},
					
				]
			});
		}
		
		// No Sorting
		$('#datatable2').DataTable({
			"bLengthChange":   false,
			"bInfo": false,
			"searching": false,
			"bPaginate": false, 
			"order": [],	
			"columnDefs": [ {
				"targets"  : 'nosort',
				  "orderable": false,
			} ]
		});

		// data grid generation
        	$('#mydatatable').DataTable().destroy();
        	var dg = $("#mydatatable").DataTable({
        		processing: true,
        		serverSide: true,
        		//paging: false,
        		searching: false,
        		//bStateSave: true, // save datatable state(pagination, sort, etc) in cookie.
        		ajax: {
        			url: "{!! $module !!}/ajax/listing?_token=<?php echo csrf_token(); ?>", // ajax source
        			type: "POST",
        			data : function(d) {
        				for (var attrname in dg_ajax_params) { d[attrname] = dg_ajax_params[attrname]; }
        				d.search_columns = $('.search_columns').val();

        			}
        		},
        		drawCallback: function (settings) {

        		},
        		lengthMenu: [
        			[10, 20, 50, 100, - 1],
        			[10, 20, 50, 100, "All"] // change per page values here
        		],
        		pageLength: 10, // default record count per page
        		columnDefs : [
        			{
                        data: "ids",
                        orderable: false,
                        width: "5%",
                        className: 'txt-center',
                        targets: 0
                    }, {
                        data: "slug",
                        width: "15%",
                        orderable: true,
                        targets: 1
                    }, {
                        data: "title",
                        width: "40%",
                        orderable: true,
                        targets: 2
                    }, {
                        data: "created_at",
                        width: "15%",
                        orderable: true,
                        targets: 3
                    }, {
                        data: "updated_at",
                        orderable: true,
                        width: "15%",
                        targets: 4
                    }, {
                        data: "options",
                        orderable: false,
                        className: 'txt-center',
                        width: "10%",
                        targets: 5
                    }
        		],
        		order: [
        			[4, "desc"]
        		]
        	});
        	// add search to datatable
        	dgSearch(dg);
        	// add select actions to datatable
        	dgSelectActions(dg);
	});
</script>
@include(config('panel.DIR').'footer')