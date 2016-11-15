<its-aulas inline-template>
	<div class="content-area tab content-palestrantes">
		<div class="row">
			<div>
				<h2 class="tab-title list-title left">aulas</h2>
				<h5 class="list-title">agenda <i class="fa fa-calendar"></i></h5>
				<ul>
					<li v-for="(aula, i) in aulas">
						<b>{{ i }}º aula</b>
						<br>
						<p>{{ aula.date }}</p>
					</li>
				</ul>
			</div>
			<div style="display: block; flex: 1">
			<div class="tab-content" v-for="aula in aulas"> 
				<h1 class="list-title">{{ aula.title }}</h1>
				<p>{{ aula.subtitle }} | {{ aula.palestrante }}</p>
				<div class="aula-content"> {{ aula.content }} </div>
			</div>
			</div>
		</div>
	</div>
</its-aulas>