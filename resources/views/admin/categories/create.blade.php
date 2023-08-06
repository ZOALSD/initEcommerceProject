@extends('admin.index')
@section('content')

@include("admin.layouts.components.submit_form_ajax",["form"=>"#categories"])
<div class="card card-dark">
	<div class="card-header">
		<h3 class="card-title">
		<div class="">
			<span>
			{{ !empty($title)?$title:'' }}
			</span>
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
			<span class="sr-only"></span>
			</a>
			<div class="dropdown-menu" role="menu">
				<a href="{{ aurl('categories') }}"  style="color:#343a40"  class="dropdown-item">
				<i class="fas fa-list"></i> {{ trans('admin.show_all') }}</a>
			</div>
		</div>
		</h3>
		<div class="card-tools">
			<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
			<button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
		</div>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
								
{!! Form::open(['url'=>aurl('/categories'),'id'=>'categories','files'=>true,'class'=>'form-horizontal form-row-seperated']) !!}
<div class="row">

<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('category_name',trans('admin.category_name'),['class'=>' control-label']) !!}
            {!! Form::text('category_name',old('category_name'),['class'=>'form-control','placeholder'=>trans('admin.category_name')]) !!}
    </div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	<div class="form-group">
		{!! Form::label('category_id',trans('admin.category_id')) !!}
		{!! Form::select('category_id',App\Models\category::pluck("category_name","id"),old('category_id'),['class'=>'form-control select2','placeholder'=>trans('admin.choose')]) !!}
	</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 image">
    <div class="form-group">
        <label for="'image'">{{ trans('admin.image') }}</label>
        <div class="input-group">
            <div class="custom-file">
                {!! Form::file('image',['class'=>'custom-file-input','placeholder'=>trans('admin.image'),"accept"=>it()->acceptedMimeTypes("image"),"id"=>"image"]) !!}
                {!! Form::label('image',trans('admin.image'),['class'=>'custom-file-label']) !!}
            </div>
            <div class="input-group-append">
                <span class="input-group-text" id="">{{ trans('admin.upload') }}</span>
            </div>
        </div>
    </div>
</div>

</div>
		<!-- /.row -->
	</div>
	<!-- /.card-body -->
	<div class="card-footer"><button type="submit" name="add" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add') }}</button>
<button type="submit" name="add_back" class="btn btn-success btn-flat"><i class="fa fa-plus"></i> {{ trans('admin.add_back') }}</button>
{!! Form::close() !!}	</div>
</div>
@endsection