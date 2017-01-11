<div class="single-menu single-header-drop-down" v-cloak>
		<span>{{ its_tabs[single_menu_active] }}</span>
		<ul class="dropdown">
			<li v-for="(tab, i) in its_tabs" >
				<a v-bind:href="'#tab_' + i" @click="changeSingleMenu(i)" v-bind:class="{ 'active' : single_menu_active == i }">{{ tab }}</a>
			</li>
		</ul>
</div>