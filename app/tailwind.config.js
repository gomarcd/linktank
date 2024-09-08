/** @type {import('tailwindcss').Config} */
export default {	
	content: [
			"./resources/**/*.blade.php",
			"./vendor/masmerise/livewire-toaster/resources/views/*.blade.php",		
			"./resources/**/*.js",
			"./resources/**/*.vue",
			"./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
			"./vendor/robsontenorio/mary/src/View/Components/**/*.php"
		],
	theme: {
		extend: {},
	},
	plugins: [
			require("daisyui")
	],
	daisyui: {
		themes: [
		  "light",
		  "dark",
		  "cupcake",
		  "bumblebee",
		  "emerald",
		  "corporate",
		  "synthwave",
		  "retro",
		  "cyberpunk",
		  "valentine",
		  "halloween",
		  "garden",
		  "forest",
		  "aqua",
		  "lofi",
		  "pastel",
		  "fantasy",
		  "wireframe",
		  "black",
		  "luxury",
		  "dracula",
		  "cmyk",
		  "autumn",
		  "business",
		  "acid",
		  "lemonade",
		  "night",
		  "coffee",
		  "winter",
		  "dim",
		  "nord",
		  "sunset",
		],
	  },	
}

