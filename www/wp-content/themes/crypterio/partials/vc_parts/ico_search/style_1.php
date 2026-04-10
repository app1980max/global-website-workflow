<div id="stm_ico_search">
	<div class="inner">
		<input type="text"
			   v-model="s"
			   v-on:keydown="searchICO()"
			   placeholder="<?php esc_html_e('Search ICO Name', 'crypterio'); ?>"
			   class="form-control"/>
		<i v-bind:class="isLoading"></i>

		<div class="stm_ico_search__results" v-if="results && s.length > 0">
			<a :href="result.url"
			   class="stm_ico_search__result mtc tbc_h"
			   v-for="result in results">
				{{result.title}}
			</a>
		</div>
	</div>
</div>