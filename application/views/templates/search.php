<script>
	function ordenar(campo){
		$('#orderby').val(campo);
		if ($('#order').val() == 'desc'){
			$('#order').val('asc');
		}
		else{
			$('#order').val('desc');
		}
		$('#form<?php echo ucwords($table) ?>').submit();
	}
	function doSubmit(){
		$('#form<?php echo ucwords($table) ?>').submit();
	}
	$(document).ready(function() {
		orderby= '<?php if (isset($criteria["orderby"])) echo $criteria["orderby"];?>';
		order= '<?php if (isset($criteria["order"]))  echo $criteria["order"];?>';
		if (order == 'desc'){
			$('#sort_'+orderby).removeClass("sorting_asc");  
			$('#sort_'+orderby).removeClass("sorting");  
			$('#sort_'+orderby).addClass("sorting_desc");
		}
		else{
			$('#sort_'+orderby).removeClass("sorting_desc");  
			$('#sort_'+orderby).removeClass("sorting");  
			$('#sort_'+orderby).addClass("sorting_asc");
		}
	});
</script>

<div id="datatable-2_filter" class="dataTables_filter" style="float:right">
		
	<input type="hidden" name="orderby" id="orderby" value="<?php if (isset($criteria['orderby'])) echo $criteria['orderby'];?>" >
	<input type="hidden" name="order" id="order" value="<?php if (isset($criteria['order'])) echo $criteria['order'];?>">

	<select class="form-control" style="float:right; width:70px" name="itemsPerPage" onchange="$('#form<?php echo ucwords($table) ?>').submit();">
		<option <?php if ($itemsPerPage == 10)echo 'selected' ?> >10</option>
		<option <?php if ($itemsPerPage == 20)echo 'selected' ?> >20</option>
		<option <?php if ($itemsPerPage == 50)echo 'selected' ?> >50</option>
		<option <?php if ($itemsPerPage == 100)echo 'selected' ?> >100</option>
		<option <?php if ($itemsPerPage == 200)echo 'selected' ?> >200</option>
	</select>
	
	<input type="button" onclick="doSubmit()" value="&raquo;" style="float:right; width:25px;margin-right:5px; margin-left:2px" class="btn btn-default">
	<input class="form-control" type="text" style="float:right; width:150px" name="searchtext" id="searchtext" value="<?php if (!empty($criteria['searchtext'])) echo urldecode($criteria['searchtext']);?>" placeholder="Buscar"  >
	
</div>

