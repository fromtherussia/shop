<?php

class Pager
{
	private $m_pageName = '';
	private $m_countPages = 0;
	private $m_itemsPerPage = 0;
	private $m_pagerText = '';
	
	public function __construct ($pageName, $countItems, $itemsPerPage = 20, $pagerText = '', $pagesVisible = 1)
	{
		$this->m_pageName = $pageName;
		$this->m_countPages = (int)($countItems / $itemsPerPage);
		if($countItems == 0)
		{
			$this->m_countPages = 1;
		}
		else if($countItems % $itemsPerPage != 0)
		{
			$this->m_countPages ++;
		}
		
		if($this->GetPageNo() > $this->m_countPages)
		{
			setcookie($this->GetPageCookieName(), 1);
			$_COOKIE[$this->GetPageCookieName()] = 1;
		}
		
		$this->m_itemsPerPage = $itemsPerPage;
		$this->m_pagesVisible = $pagesVisible;
		$this->m_pagerText = $pagerText;
	}
	
	private function GetPageCookieName ()
	{
		return $this->m_pageName . '_page_no';;
	}
	
	private function GetPageNo ()
	{
		if(empty($_COOKIE[$this->GetPageCookieName()]))
		{
			return 1;
		}
		return $_COOKIE[$this->GetPageCookieName()];
	}
	
	public function GetLowerLimit ()
	{
		return ($this->GetPageNo() - 1) * $this->m_itemsPerPage;
	}
	
	public function GetUpperLimit ()
	{
		return $this->m_itemsPerPage;
	}
	
	private function RenderPageSelector ($pageNo = null)
	{
		if($pageNo)
		{
			$pageSelectorClass = 'page';
			if($this->GetPageNo() == $pageNo)
			{
				$pageSelectorClass .= ' current';
			}
			$pageName = $this->m_pageName;
			echo "<div onclick=\"{$pageName}_changePage($pageNo)\" class=\"$pageSelectorClass\">$pageNo</div>";
		}
		else
		{
			echo '<div class="page">..</div>';
		}
	}

	public function render ($changePageHandler)
	{
		$minLeftPage = $this->GetPageNo() - $this->m_pagesVisible;
		$maxRightPage = $this->GetPageNo() + $this->m_pagesVisible;
		
		echo '<div class="pager">';
		echo '<div class="title">' . $this->m_pagerText . '</div>';
		$this->RenderPageSelector(1);
		if($minLeftPage > 2)
		{
			$this->RenderPageSelector();
		}
		for($i = max(2, $minLeftPage); $i <= min($this->m_countPages - 1, $maxRightPage); $i++)
		{
			$this->RenderPageSelector($i);
		}
		if($maxRightPage < $this->m_countPages - 1)
		{
			$this->RenderPageSelector();
		}
		if($this->m_countPages > 1)
		{
			$this->RenderPageSelector($this->m_countPages);
		}
		echo '<br class="clear" />';
		echo '</div>';
		?>
		<script>
			function <?php printText($this->m_pageName) ?>_changePage (pageNo)
			{
				$.cookie("<?php printText($this->GetPageCookieName()) ?>", pageNo);
				<?php printText($changePageHandler)?>(pageNo);
			}
		</script>
		<?php
	}
}