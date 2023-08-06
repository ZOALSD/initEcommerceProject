<?php

namespace App\DataTables;

use App\Models\Admin;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Services\DataTable;

// Auto DataTable By Baboon Script
// Baboon Maker has been Created And Developed By
// Copyright Reserved
class AdminsDataTable extends DataTable
{

	public function dataTable(DataTables $dataTables, $query)
	{
		return datatables($query)
			->addColumn('actions', 'admin.admins.buttons.actions')
			->addColumn('photo_profile', '{!! view("admin.show_image",["image"=>$photo_profile])->render() !!}')
			->addColumn('checkbox', '<div  class="icheck-danger">
                  <input type="checkbox" class="selected_data" name="selected_data[]" id="selectdata" value="{{ $id }}" >
                  <label for="selectdata"></label>
                </div>')
			->rawColumns(['checkbox', 'actions', 'photo_profile']);
	}

	/**
	 * Get the query object to be processed by dataTables.
	 * Auto Ajax Method By Baboon Script
	 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
	 */
	public function query()
	{
		return Admin::query()->with(['group_id'])->select("admins.*");
	}

	/**
	 * Optional method if you want to use html builder.

	 * @return \Yajra\Datatables\Html\Builder
	 */
	public function html()
	{
		$html = $this->builder()
			->columns($this->getColumns())
			//->ajax('')
			->parameters([
				'searching'   => true,
				'paging'   => true,
				'bLengthChange'   => false,
				'bInfo'   => true,
				'responsive'   => true,
				'dom' => 'Blfrtip',
				"lengthMenu" => [[10, 25, 50, 100, -1], [10, 25, 50, 100, trans('admin.all_records')]],
				'buttons' => [
					[
						'text' => '<i class="fa fa-plus"></i> ' . trans('admin.add'),
						'className' => 'btn btn-primary',
						'action' => 'function(){
                        	window.location.href =  "' . \URL::current() . '/create";
                        }',
					],
				],
				'initComplete' => "function () {


           

            }",
				'order' => [[1, 'desc']],

				'language' => [
					'sProcessing' => trans('admin.sProcessing'),
					'sLengthMenu' => trans('admin.sLengthMenu'),
					'sZeroRecords' => trans('admin.sZeroRecords'),
					'sEmptyTable' => trans('admin.sEmptyTable'),
					'sInfo' => trans('admin.sInfo'),
					'sInfoEmpty' => trans('admin.sInfoEmpty'),
					'sInfoFiltered' => trans('admin.sInfoFiltered'),
					'sInfoPostFix' => trans('admin.sInfoPostFix'),
					'sSearch' => trans('admin.sSearch'),
					'sUrl' => trans('admin.sUrl'),
					'sInfoThousands' => trans('admin.sInfoThousands'),
					'sLoadingRecords' => trans('admin.sLoadingRecords'),
					'oPaginate' => [
						'sFirst' => trans('admin.sFirst'),
						'sLast' => trans('admin.sLast'),
						'sNext' => trans('admin.sNext'),
						'sPrevious' => trans('admin.sPrevious'),
					],
					'oAria' => [
						'sSortAscending' => trans('admin.sSortAscending'),
						'sSortDescending' => trans('admin.sSortDescending'),
					],
				],
			]);

		return $html;
	}

	/**
	 * Get columns.
	 * Auto getColumns Method By Baboon Script
	 * @return array
	 */

	protected function getColumns()
	{
		return [
			[
				'name' => 'id',
				'data' => 'id',
				'title' => trans('admin.record_id'),
				'width' => '10px',
				'aaSorting' => 'none',
			],
			[
				'name' => 'name',
				'data' => 'name',
				'title' => trans('admin.name'),
			],
			[
				'name' => 'photo_profile',
				'data' => 'photo_profile',
				'title' => trans('admin.photo_profile'),
			],
			[
				'name' => 'email',
				'data' => 'email',
				'title' => trans('admin.email'),
			],
			[
				'name' => 'group_id.group_name',
				'data' => 'group_id.group_name',
				'title' => trans('admin.group_id'),
			],
			[
				'name' => 'actions',
				'data' => 'actions',
				'title' => trans('admin.actions'),
				'exportable' => false,
				'printable' => false,
				'searchable' => false,
				'orderable' => false,
			],
		];
	}

	/**
	 * Get filename for export.
	 * Auto filename Method By Baboon Script
	 * @return string
	 */
	protected function filename()
	{
		return 'admins_' . time();
	}
}
