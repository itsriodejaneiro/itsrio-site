<div class="single-menu show-for-medium single-header-drop-down">
		<span>{{ its_tabs[single_menu_active] }}</span>
		<ul class="dropdown">
			<li v-for="(tab, i) in its_tabs" @click="single_menu_active = i">
				<a v-bind:href="'#tab_' + i" v-bind:class="{ 'active' : single_menu_active == i }">{{ tab }}</a>
			</li>
		</ul>
</div>