<style>
    .academic-footer {
        background-color: var(--accent-soft, #F5EBE6);
        border-top: 1px solid var(--border-color, #EADCD3);
        padding: 40px 5%;
        font-family: var(--font-body, 'Plus Jakarta Sans', sans-serif);
        color: var(--text-secondary, #6F5D56);
        font-size: 14px;
        line-height: 1.6;
        margin-top: auto;
        width: 100%;
        position: relative;
        z-index: 10;
        display: flex;
        justify-content: center;
    }
    body.dark .academic-footer {
        background-color: var(--accent-soft, #30231D);
        border-top: 1px solid var(--border-color, #382B24);
        color: var(--text-secondary, #CBBAB3);
    }
    .academic-footer-content {
        max-width: 1000px;
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 24px;
        align-items: center;
        text-align: center;
    }
    .academic-footer .group-title {
        font-family: var(--font-heading, 'Outfit', sans-serif);
        font-size: 20px;
        font-weight: 800;
        color: var(--accent-primary, #8B5E3C);
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    body.dark .academic-footer .group-title {
        color: var(--accent-primary, #E7A774);
    }
    .academic-footer .group-members {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        width: 100%;
    }
    .academic-footer .member-card {
        background: rgba(139, 94, 60, 0.04);
        padding: 16px 20px;
        border-radius: 12px;
        border: 1px solid rgba(139, 94, 60, 0.1);
        text-align: left;
    }
    body.dark .academic-footer .member-card {
        background: rgba(231, 167, 116, 0.05);
        border: 1px solid rgba(231, 167, 116, 0.15);
    }
    .academic-footer .member-card p {
        margin-bottom: 4px;
        color: var(--text-primary, #2A1A12);
    }
    body.dark .academic-footer .member-card p {
        color: var(--text-primary, #FAF6F3);
    }
    .academic-footer .member-card p:last-child {
        margin-bottom: 0;
    }
    .academic-footer .academic-info {
        font-size: 14px;
        font-weight: 500;
        padding-top: 16px;
        border-top: 1px dashed var(--border-color, #EADCD3);
        width: 100%;
    }
    body.dark .academic-footer .academic-info {
        border-top-color: var(--border-color, #382B24);
    }
    
    @media (max-width: 768px) {
        .academic-footer {
            padding: 30px 20px;
        }
        .academic-footer .group-members {
            grid-template-columns: 1fr;
        }
    }
</style>
<div class="academic-footer">
    <div class="academic-footer-content">
        <div class="group-title">Kelompok 3 Pemrograman Web KH001</div>
        
        <div class="group-members">
            <div class="member-card">
                <p><strong>Nama:</strong> Muhammad Alif Farhan</p>
                <p><strong>NIM:</strong> 20240803035</p>
            </div>
            <div class="member-card">
                <p><strong>Nama:</strong> Nabila Aprilia Putri</p>
                <p><strong>NIM:</strong> 20240803099</p>
            </div>
            <div class="member-card">
                <p><strong>Nama:</strong> Putri Kurnia Sari</p>
                <p><strong>NIM:</strong> 20240803055</p>
            </div>
        </div>

        <div class="academic-info">
            <p>Dosen Pengampu Mata Kuliah: Dewi Setiowati, A.Md., S.Pd., M.Tr.Kom.</p>
            <p>Tahun Akademik 2025/2026 Genap</p>
        </div>
    </div>
</div>
