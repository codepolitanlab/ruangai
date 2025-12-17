<div id="prompts" x-data="promptsPage()"></div>
<script>
Alpine.data('promptsPage', () => ({
    module: 'prompts',
    init() {
        let token = localStorage.getItem('heroic_token');
        window.location.href = 'https://prompt.ruangai.id/?heroic_token=' + token;
    },
}));
</script>