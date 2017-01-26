<div class="single-menu single-header-drop-down">
		<span>{{ its_tabs[single_menu_active] }}</span>
		<ul class="dropdown">
			<li v-for="(tab, i) in its_tabs" >
				<a :href="'#tab_' + i" @click="changeSingleMenu(i)" :class="{ 'active' : single_menu_active == i }">{{ tab }}</a>
			</li>
		</ul>
</div>