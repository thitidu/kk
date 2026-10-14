(() => {
    const search = document.getElementById('catalogSearch');
    const teamFilter = document.getElementById('teamFilter');
    const positionFilter = document.getElementById('positionFilter');
    const emptyMessage = document.getElementById('catalogEmpty');
    const catalogItems = document.getElementById('catalogItems');

    function filterCatalog() {
        const query = search.value.trim().toLocaleLowerCase();
        const teamId = teamFilter?.value || '';
        const position = positionFilter?.value || '';
        let visibleCount = 0;

        catalogItems.querySelectorAll('[data-search]').forEach((item) => {
            const visible = item.dataset.search.includes(query)
                && (!teamId || item.dataset.team === teamId)
                && (!position || item.dataset.position === position);
            item.hidden = !visible;
            if (visible) visibleCount += 1;
        });

        emptyMessage.hidden = visibleCount > 0;
    }

    search.addEventListener('input', filterCatalog);
    positionFilter?.addEventListener('change', filterCatalog);
    teamFilter?.addEventListener('change', () => {
        const url = new URL(window.location.href);
        if (teamFilter.value) url.searchParams.set('team_id', teamFilter.value);
        else url.searchParams.delete('team_id');
        window.location.assign(url);
    });
})();
