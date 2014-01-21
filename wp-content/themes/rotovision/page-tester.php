<?php
/*
Template Name: Testing ground
*/
?>
<?php get_header(); ?>

<h1>Testing ground</h1>

<?php /*
if(function_exists('wp_custom_fields_search')) 
	wp_custom_fields_search();
*/ ?>


<?php
/**
 * The template for displaying default search form.
 *
 * This is the template that displays default searchform.
 *
 * @package WordPress
 * @subpackage Real_Dreams
 * @since Real Dreams 1.0
 */
?>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>">
	<input type="hidden" name="scope" value="books">
	<input type="hidden" name="cat" value="front-list">
		<fieldset>
			<input type="text" class="textfield" name="s" id="s" value=""/>
			<ul class="check_set">
				<li><input type="radio" name="searchby" value="title" id="radio_title"/> <label for="radio_title">TITLE</label></li>
				<li><input type="radio" name="searchby" value="subject" id="radio_subject"/> <label for="radio_subject">SUBJECT</label></li>
				<li><input type="radio" name="searchby" value="keyword" id="radio_keyword"/> <label for="radio_keyword">KEYWORD</label></li>
				<li><input type="radio" name="searchby" value="author" id="radio_author"/> <label for="radio_author">AUTHOR</label></li>
				<li><input type="radio" name="searchby" value="publisher" id="radio_publisher"/> <label for="radio_publisher">PUBLISHER</label></li>
				<li><input type="radio" name="searchby" value="isbn" id="radio_isbn"/> <label for="radio_isbn">ISBN</label></li>
			</ul>
		</fieldset>
		<input type="submit" class="button submit button_search" name="submit" value="Go"/>
	<? /*
	
	
	
	
<div id="contentformserch">
		<div class="columnsformsmall">
			<span>Prezzo min.</span><br/>
			<input type="text" size="22" id="nome" name="prezzomin" value="" class="prezzo" title="inserisci un prezzo di partenza minimo"/>
		</div>
		<div class="columnsformsmall">
			<span>Prezzo max</span><br/>
			<input type="text" size="22" id="nome" name="prezzomax" value="" class="prezzo" title="inserisci il prezzo massimo"/>
		</div>
		<div class="columnsformlarge">
			<span>Tipologia</span><br/>
			<div class="contentselector car"><input type="radio" name="tipologia" value="automobili"></div>
			<div class="contentselector boat"><input type="radio" name="tipologia" value="imbarcazioni"></div>
		</div>
		<div class="columnsformlarge">
			<span>Parola chiave (marchio o altro)</span><br/>
			<input type="text" size="22" id="nome" name="s" id="s" value="<?php if(trim(wp_specialchars($s,1))!='') echo trim(wp_specialchars($s,1));else echo ' ';?>" class="parolachiave" title="inserisci i termini che vuoi cercare" value="&bnsp;" />
		</div>
		<div class="columnsformsmall nota">
			<p>
			oppure consulta il<br/>
			<a href="<?php echo get_post_type_archive_link('vendita')?>" title="Vedi l'elenco degli annunci disponibili">nostro archivio </a>
			</p>
		</div>
		<div class="columnsformsmall">
			<input type="submit" name="sa" class="button cerca" id="searchsubmit" />
		</div>
	</div>
*/ ?>
</form>

<?php get_footer(); ?>