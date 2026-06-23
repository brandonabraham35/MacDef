</main></div></div>
<script>
document.querySelectorAll('.confirm-delete').forEach(f=>f.addEventListener('submit',e=>{if(!confirm('Delete this item?'))e.preventDefault()}));

// Sidebar Collapsible Toggle
document.querySelectorAll('.nav-group-header').forEach(header => {
    header.addEventListener('click', () => {
        const group = header.parentElement;
        const isOpen = group.classList.contains('open');

        // Close all other groups
        document.querySelectorAll('.nav-item-group').forEach(g => {
            g.classList.remove('open');
        });

        // Toggle current group
        if (!isOpen) {
            group.classList.add('open');
        }
    });
});
</script>
</body></html>
