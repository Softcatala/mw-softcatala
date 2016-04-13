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
		$html = $this->extractTocContents($this->data['bodycontent']);
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
				                  <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $this->getCurrentUrl() ?>"><i class="fa fa-facebook"></i></a></li>
				                  <li><a href="https://twitter.com/intent/tweet?text=<?php echo $this->getCurrentUrl() ?> <?php echo $this->data['title'] ?>"><i class="fa fa-twitter"></i></a></li>
				                  <li><a href="https://plus.google.com/share?url=<?php echo $this->getCurrentUrl() ?>"><i class="fa fa-google-plus"></i></a></li>
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
				echo $html['toc'];
				?>
				<div class="caixa-gris">
                <p>Eines d'usuari</p>
                <?php
                $personalTools = $this->getPersonalTools();
                foreach ( $personalTools as $key => $item ): ?>
                        <a href="<?php echo $item['links'][0]['href'] ?>" title="<?php echo $item['links'][0]['single-id'] ?>"><i class="<?php echo $this->getIconList($item['links'][0]['single-id']) ?>"> </i> <span><?php echo $item['links'][0]['text'] ?></span></a>
                <?php endforeach; ?>
                </div><br/>

				<form id="p-search" class="searchform" role="search" action="<?php $this->text( 'wgScript' ) ?>">
                    <input type="hidden" value="Especial:Cerca" name="title">
                    <div class="input-group">
                    <input type="search" id="searchInput" accesskey="f" title="Cerca a Softcatalà [Alt+Maj+f]" placeholder="Cerca" name="search" class="cerca_input">
                    <span class="input-group-addon">
                    <button type="submit" class="btn lupa" id="searchGoButton" value="Vés-hi" name="go">
                    <i class="fa fa-search"></i>
                    </button>
                    </span>
                    </div>
                </form>
				<?php
				$this->outputPageLinks();
				?>

<div id="p-views" class="caixa-gris">
					<ul>
						<li id="ca-view" class="selected">
							<a accesskey="h" title="Versions antigues d'aquesta pàgina [Alt+Maj+h]" href="/wiki/Especial:Enlla%C3%A7os/<?php $this->html( 'title' ) ?>">Qui hi enllaça</a>
						</li>
					</ul>
				</div>

				</aside>
				<div class="contingut col-sm-9">
				<header class="contingut-header">
                <h1><?php $this->html( 'title' ) ?></h1>
                </header>
				<section class="contingut-section">
				<?php
				if ( isset ( $html['content'] ) ) {
				    echo $html['content'];
				} else {
				    $this->html( 'bodycontent' );
				}

                                if ( $this->data['catlinks'] ) {
					$this->html( 'catlinks' );
				}

				if ( $this->data['dataAfterContent'] ) {
					$this->html( 'dataAfterContent' );
				}

				 ?>
				</section>
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
		<div class="caixa-gris"
			id="<?php echo Sanitizer::escapeId( $box['id'] ) ?>"
			<?php echo Linker::tooltip( $box['id'] ) ?>
		>
			<p>
				<?php
				if ( isset( $box['headerMessage'] ) ) {
					echo $this->getMsg( $box['headerMessage'] )->escaped();
				} else {
					echo htmlspecialchars( $box['header'], ENT_QUOTES );
				}
				?>
			</p>

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
		if ( isset $_GET['action'] )) {
			$action = $_GET['action'];
		    if ( $action != 'edit') {
		        $dom = new DOMDocument();

	            $dom->loadHTML('<?xml version="1.0" encoding="UTF-8"?>' . $html);
	            $xpath = new DOMXPath($dom);
	            $div = $xpath->query('//div[@id="toc"]');
	            $div = $div->item(0);

	            if ( ! empty ( $div ) ) {

	                $toc = $dom->saveXML($div);
	                $toc = str_replace( '<div id="toctitle"><h2>Contingut</h2></div>', '', $toc );
	                $toc = str_replace( 'id="toc" class="toc"', '', $toc );
	                $toc = str_replace( '<ul>', '<ul id="menu-lateral" class="nav collapse navbar-collapse">', $toc );

	                preg_match_all('/<span class=\"tocnumber\">(.*)<\/span>/iU', $toc, $match);
	                foreach ( $match[0] as $number ) {
	                    $toc = str_replace( $number, '', $toc );
	                }

	                $content['toc'] = $toc.'<br/>';
	                $div->parentNode->removeChild($div);
	            } else {
	                $content['toc'] = '';
	            }

	            $content['content'] = $dom->saveXML();
			}
			else {
				$content = array();
			}
		} else {
	        $content = array();
	    }

        return $content;
	}

	private function getCurrentUrl()
	{
	    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	    return $actual_link;
	}

    /**
     * This function returns the 'awesome' icon for each element of the user actions list
     * @param $item
     * @return string
     */
	private function getIconList($item)
	{
	    switch($item) {
	        case 'pt-userpage':
	            $icon = 'fa fa-home fa-fw';
	            break;
	        case 'pt-mytalk':
	            $icon = 'fa fa-quote-left';
	            break;
	        case 'pt-watchlist':
	            $icon = 'fa fa-list';
	            break;
	        case 'pt-mycontris':
	            $icon = 'fa fa-dot-circle-o';
	            break;
	        case 'pt-logout':
	            $icon = 'fa fa-sign-out';
	            break;
	        default:
	            $icon = 'fa fa-cog fa-fw';
	    }

	    return $icon;
	}
}
