<?php
/**
 * BaseTemplate class for the Softcatala skin
 *
 * @ingroup Skins
 */
class SoftcatalaTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->html( 'headelement' );
		?>
		<main class="main wrap-blanc cd-main-content">
			<header class="main-header">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xxs-12 col-xs-8 col-sm-9">
							<h1><?php $this->html( 'title' ) ?></h1>
							<div class="compartiu">
				                <p>Compartiu</p>
				                <ul class="compartiu-media">
				                  <li><a href="#"><i class="fa fa-facebook"></i></a></li>
				                  <li><a href="#"><i class="fa fa-twitter"></i></a></li>
				                  <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
				                </ul>
			              	</div>
						</div>
					</div>
				</div>
			</header>
			<div class="container-fluid">
				<aside class="aside-left col-sm-3">
				<div class="visible-xs-block boto-menu-lateral">
	              <a aria-controls="#menu-lateral" aria-expanded="false" data-toggle="collapse" href="#menu-lateral" class="bt-menu-lateral">
	                <i class="fa fa-bars"></i>
	                  <p>Taula de continguts</p>
	                <i class="fa fa-chevron-down"></i>
	              </a>
	            </div>
				<?php
				echo '<ul id="menu-lateral" class="nav collapse navbar-collapse">';
					$personalTools = $this->getPersonalTools();
							foreach ( $personalTools as $key => $item ) {
								echo $this->makeListItem( $key, $item );
							}
				echo '</ul><br/>';
				$this->outputSearch();
				echo '<div id="page-tools">';
					$this->outputPageLinks();
				echo '</div><div id="site-navigation">';
					$this->outputSiteNavigation();
				echo '</div>';
				?>
				</aside>
				<div class="contingut col-sm-9">
				<?php $html = $this->extractTocContents($this->data['bodycontent']);
                    echo $html['content'];
					$this->clear();
					?>
				</div>	
			</div>
		</main>
		<div id="mw-wrapper">
			<div class="mw-body" role="main">
				<?php
				if ( $this->data['sitenotice'] ) {
					?>
					<div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div>
					<?php
				}
				if ( $this->data['newtalk'] ) {
					?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
					<?php
				}
				echo $this->getIndicators();
				?>
			</div>
		</div>

		<!--#include virtual="/ssi/footer-content.html" -->

		<?php $this->printTrail() ?>
		</body></html>

		<?php
	}

	/**
	 * Outputs a single sidebar portlet of any kind.
	 */
	private function outputPortlet( $box ) {
		if ( !$box['content'] ) {
			return;
		}

		?>
		<div
			role="navigation"
			class="mw-portlet"
			id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"
			<?php echo Linker::tooltip( $box['id'] ) ?>
		>
			<h3>
				<?php
				if ( isset( $box['headerMessage'] ) ) {
					echo $this->getMsg( $box['headerMessage'] )->escaped();
				} else {
					echo htmlspecialchars( $box['header'], ENT_QUOTES );
				}
				?>
			</h3>

			<?php
			if ( is_array( $box['content'] ) ) {
				echo '<ul>';
				foreach ( $box['content'] as $key => $item ) {
					echo $this->makeListItem( $key, $item );
				}
				echo '</ul>';
			} else {
				echo $box['content'];
			}?>
		</div>
		<?php
	}

	/**
	 * Outputs the logo and (optionally) site title
	 */
	private function outputLogo( $id = 'p-logo', $imageOnly = false ) {
		?>
		<div id="<?php echo $id ?>" class="mw-portlet" role="banner">
			<a
				class="mw-wiki-logo"
				href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'], ENT_QUOTES )
			?>" <?php
			echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) )
			?>></a>
			<?php
			if ( !$imageOnly ) {
				?>
				<a id="p-banner" class="mw-wiki-title" href="<?php echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'], ENT_QUOTES ) ?>">
					<?php echo $this->getMsg( 'sitetitle' )->escaped() ?>
				</a>
				<?php
			}
			?>
		</div>
		<?php
	}

	/**
	 * Outputs the search form
	 */
	private function outputSearch() {
		?>
		<form
			action="<?php $this->text( 'wgScript' ) ?>"
			role="search"
			class="mw-portlet"
			id="p-search"
		>
			<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
			<h3>
				<label for="searchInput"><?php echo $this->getMsg( 'search' )->escaped() ?></label>
			</h3>
			<?php echo $this->makeSearchInput( array( 'id' => 'searchInput' ) ) ?>
			<?php echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) ) ?>
			<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
		</form>
		<?php
	}

	/**
	 * Outputs the sidebar
	 * Set the elements to true to allow them to be part of the sidebar
	 */
	private function outputSiteNavigation() {
		$sidebar = $this->getSidebar();

		$sidebar['SEARCH'] = false;
		$sidebar['TOOLBOX'] = true;
		$sidebar['LANGUAGES'] = true;

		foreach ( $sidebar as $boxName => $box ) {
			if ( $boxName === false ) {
				continue;
			}
			$this->outputPortlet( $box, true );
		}
	}

	/**
	 * Outputs page-related tools/links
	 */
	private function outputPageLinks() {
		$this->outputPortlet( array(
			'id' => 'p-namespaces',
			'headerMessage' => 'namespaces',
			'content' => $this->data['content_navigation']['namespaces'],
		) );
		$this->outputPortlet( array(
			'id' => 'p-variants',
			'headerMessage' => 'variants',
			'content' => $this->data['content_navigation']['variants'],
		) );
		$this->outputPortlet( array(
			'id' => 'p-views',
			'headerMessage' => 'views',
			'content' => $this->data['content_navigation']['views'],
		) );
		$this->outputPortlet( array(
			'id' => 'p-actions',
			'headerMessage' => 'actions',
			'content' => $this->data['content_navigation']['actions'],
		) );
	}

	/**
	 * Outputs user tools menu
	 */
	private function outputUserLinks() {
		$this->outputPortlet( array(
			'id' => 'p-personal',
			'headerMessage' => 'personaltools',
			'content' => $this->getPersonalTools(),
		) );
	}

	/**
	 * Outputs a css clear using the core visualClear class
	 */
	private function clear() {
		echo '<div class="visualClear"></div>';
	}

	private function extractTocContents($html) {
	    $before = '<div id="toc" class="toc">';
	    $after = '</div>';
        $first_step = explode( $before , $html );
        $second_step = explode($after , $first_step[1] );

        $content['toc'] = $second_step[0].$second_step[1];


        $dom = new DOMDocument();

        $dom->loadHTML('<?xml version="1.0" encoding="UTF-8"?>' . $html);
        $xpath = new DOMXPath($dom);
        $div = $xpath->query('//div[@id="toc"]');
        $div = $div->item(0);

        $content['toc'] = $dom->saveXML($div);
        $div->parentNode->removeChild($div);
        $content['content'] = $dom->saveXML();

        return $content;
	}
}
