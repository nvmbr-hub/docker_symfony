<script>
	import 'tailwindcss/tailwind.css';
</script>

<svelte:head>
	<title>Home</title>
	<meta name="description" content="Svelte demo app" />
	<link
			href="https://fonts.googleapis.com/css?family=Merriweather:300,400,500|Roboto:300,400,500|Material+Icons&display=swap"
			rel="stylesheet"
	/>
</svelte:head>

<body data-theme="skeleton">
	<a href="/" class="card p-4">Link</a>
	<a href="/" class="card p-4">Link</a>
</body>
<style>
	section {
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		flex: 0.6;
	}

	h1 {
		width: 100%;
	}

	.welcome {
		display: block;
		position: relative;
		width: 100%;
		height: 0;
		padding: 0 0 calc(100% * 495 / 2048) 0;
	}

	.welcome img {
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
		display: block;
	}
</style>