<noscript>
<?php if ($this->pageCount): ?>
    <div class="pagination pagination-centered">
        <ul>
            <li <?php echo!isset($this->previous) ? 'class="disabled"' : ''; ?>>
                <a id="pager_first" href="<?php echo $this->uri; ?>">&laquo;</a></li>
            <li <?php echo!isset($this->previous) ? 'class="disabled"' : ''; ?>>
                <a id="pager_previous" href="<?php echo $this->uri . "/" . $this->previous; ?><?php //echo $this->url($this->route, array('action'=>'page','page' => $this->previous, )); ?>">&lsaquo;</a></li>

            <!-- Numbered page links -->
            <?php foreach ($this->pagesInRange as $page): ?>
                <li <?php echo $page == $this->current ? 'class="active"' : ''; ?>><a id="pager_<?php echo $page;?>" href="<?php echo $this->uri . "/" . $page; ?><?php //echo $this->url($this->route, array('action'=>'page', 'page' => $page,)); ?>">
                        <?php echo $page; ?>
                    </a></li>
            <?php endforeach; ?>

            <!-- Next page link -->
            <li <?php echo!isset($this->next) ? 'class="disabled"' : ''; ?>>
                <a id="pager_next" href="<?php echo $this->uri . "/" . $this->next; ?><?php //echo $this->url($this->route, array('action'=>'page','page' => $this->next, )); ?>">&rsaquo;</a></li>
            <!-- Last page link -->
            <li <?php echo!isset($this->next) ? 'class="disabled"' : ''; ?>>
                <a id="pager_last" href="<?php echo $this->uri . "/" . $this->last; ?><?php //echo $this->url($this->route, array('action'=>'page', 'page' => $this->last, )); ?>">&raquo;</a></li>
        </ul>
    </div>
<?php endif; ?>
</noscript>
<script>	
	$(document).ready(function(){
		isRequested = false;
		uri = "<?php echo $this->uri; ?>";
		page = <?php echo $this->current; ?>;
		lastPage = <?php echo $this->last; ?>;
		function getAjaxProduct(uri) {
			$.ajax({
		        dataType:'json',
		        type: 'POST',
		        async: true,
		        url: uri,
		        success: function(data) {
		        	if(data.success) {
		        		$('.product-list').append(data.HTML);
		        		isRequested = false;
		            }
		        }
		    });
		}
		$(window).scroll(function(){
			if(!isRequested && page < lastPage){
			    var height = $(window).height() + 500;
		        if ($(window).scrollTop() > $(document).height() - height ){
		        	isRequested = true;
		        	page++;
		        	console.log(uri + "/" + page);
		       		getAjaxProduct(uri + "/" + page);
		       	}		      
	        }   
		});
	});
</script>

