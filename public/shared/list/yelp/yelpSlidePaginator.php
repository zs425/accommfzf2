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
    <form name="paginationform" id="paginationform" method="post" action="">
    	<input type="hidden" name="term" value="<?php echo $this->term;?>"/> 
    	<input type="hidden" name="location" value="<?php echo $this->location;?>"/>
    </form>
<?php endif; ?>

<script>    
    $(document).ready(function(){ 
        $(".pagination li a").click(function(e){
        	e.preventDefault();
        	$("#paginationform").attr('action', $(this).attr('href'));
        	$("#paginationform").submit();
        });
    });
</script>

