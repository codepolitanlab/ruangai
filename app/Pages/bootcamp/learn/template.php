<div
    id="bootcamp-learn"
    class="header-mobile-only rd-page"
    x-data="bootcamp_learn($params.id)"
    x-cloak>

    <style>
        #bootcamp-learn .bl-tabs { display: flex; gap: 6px; padding: 8px 8px; margin: 0 16px 0; background: var(--rd-surface); border: 1px solid var(--rd-border); border-radius: 14px; position: sticky; top: 0; z-index: 20; overflow-x: auto; scrollbar-width: none; -webkit-overflow-scrolling: touch; }
        #bootcamp-learn .bl-tabs::-webkit-scrollbar { display: none; }
        #bootcamp-learn .bl-tab { flex: 1 0 auto; border: none; background: none; padding: 9px 16px; border-radius: 12px; font-weight: 600; font-size: 0.8rem; color: var(--rd-text-muted); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 5px; white-space: nowrap; }
        #bootcamp-learn .bl-tab.active { background: var(--rd-primary); color: var(--rd-primary-contrast, #fff); }
        #bootcamp-learn .bl-block { margin: 14px 16px 14px; padding-bottom: 0; }
        #bootcamp-learn .bl-progress-track { display: flex; align-items: center; gap: 10px; margin: 14px 0 20px; }
        #bootcamp-learn .bl-progress-bar { flex: 1; position: relative; height: 20px; background: var(--rd-border); border-radius: 999px; overflow: hidden; }
        #bootcamp-learn .bl-progress-fill { height: 100%; border-radius: 999px; background: linear-gradient(90deg, var(--rd-primary), var(--rd-accent, #4a90e2)); display: flex; align-items: center; justify-content: center; min-width: 44px; transition: width 0.6s ease; }
        #bootcamp-learn .bl-progress-label { font-size: 0.72rem; font-weight: 800; color: #fff; text-shadow: 0 1px 2px rgba(0,0,0,0.35); white-space: nowrap; }
        #bootcamp-learn .bl-block:last-child { padding-bottom: 110px; }
        #bootcamp-learn .bl-card { background: var(--rd-surface); border: 1px solid var(--rd-border); border-radius: 16px; padding: 14px; margin-bottom: 12px; }
        #bootcamp-learn .bl-feed-title { font-weight: 700; color: var(--rd-text); font-size: 0.98rem; }
        #bootcamp-learn .bl-feed-body { color: var(--rd-text-muted); font-size: 0.9rem; margin-top: 4px; white-space: pre-line; }
        #bootcamp-learn .bl-pin { background: #fff6e6; color: #b26a00; border-radius: 999px; padding: 2px 8px; font-size: 0.7rem; font-weight: 700; }
        #bootcamp-learn .bl-material { border: 1px solid var(--rd-border); border-radius: 16px; margin-bottom: 12px; overflow: hidden; background: var(--rd-surface); position: relative; }
        #bootcamp-learn .bl-material-head { display: flex; align-items: center; gap: 12px; padding: 14px; cursor: pointer; }
        #bootcamp-learn .bl-res { border-top: 1px dashed var(--rd-border); padding: 10px 14px; display: flex; flex-direction: column; }
        #bootcamp-learn .bl-res-drop { padding: 10px 0 2px; }
        #bootcamp-learn .bl-open-btn { width: 100%; }
        #bootcamp-learn .bl-res-head { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        #bootcamp-learn .bl-res-icon { width: 34px; height: 34px; border-radius: 10px; background: var(--rd-primary-soft, #eef4fb); display: flex; align-items: center; justify-content: center; color: var(--rd-primary); flex: none; }
        #bootcamp-learn .bl-res-title { font-weight: 600; font-size: 0.92rem; color: var(--rd-text); flex: 1; }
        #bootcamp-learn .bl-badge { border-radius: 999px; padding: 3px 9px; font-size: 0.7rem; font-weight: 700; flex: none; }
        #bootcamp-learn .bl-badge.done { background: #e6f6ec; color: #1a7f4b; }
        #bootcamp-learn .bl-badge.ongoing { background: #eef4fb; color: #2563eb; }
        #bootcamp-learn .bl-badge.wait { background: #f3f4f6; color: #6b7280; }
        #bootcamp-learn .bl-btn { border: none; border-radius: 999px; padding: 9px 14px; font-size: 0.85rem; font-weight: 700; cursor: pointer; }
        #bootcamp-learn .bl-btn.primary { background: var(--rd-primary); color: var(--rd-primary-contrast, #fff); }
        #bootcamp-learn .bl-btn.outline { background: transparent; border: 1.5px solid var(--rd-primary); color: var(--rd-primary); }
        #bootcamp-learn .bl-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        #bootcamp-learn .bl-lock { position: absolute; inset: 0; background: rgba(2, 13, 28, 0.9); backdrop-filter: blur(2px); -webkit-backdrop-filter: blur(2px); display: flex; align-items: center; justify-content: center; z-index: 5; border-radius: 16px; padding: 20px; }
        #bootcamp-learn .bl-lock-box { text-align: center; max-width: 260px; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 18px 20px; }
        #bootcamp-learn .bl-lock-box i { font-size: 1.8rem; color: var(--rd-primary); }
        #bootcamp-learn .bl-lock-title { font-weight: 700; color: var(--rd-text); margin-top: 8px; font-size: 0.95rem; }
        #bootcamp-learn .bl-lock-sub { font-size: 0.82rem; color: var(--rd-text-muted); margin-top: 2px; line-height: 1.5; }
        #bootcamp-learn .bl-member { display: flex; align-items: center; gap: 10px; padding: 10px 0; border-bottom: 1px solid var(--rd-border); }
        #bootcamp-learn .bl-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--rd-primary-soft, #eef4fb); color: var(--rd-primary); display: flex; align-items: center; justify-content: center; font-weight: 700; flex: none; }
        #bootcamp-learn .bl-video-wrap { position: relative; padding-top: 56.25%; border-radius: 12px; overflow: hidden; margin-top: 10px; background: #000; }
        #bootcamp-learn .bl-video-wrap iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
        #bootcamp-learn .bl-pdf-wrap { margin-top: 12px; border: 1px solid var(--rd-border); border-radius: 12px; overflow: hidden; background: #fff; }
        #bootcamp-learn .bl-pdf-wrap iframe { width: 100%; height: 58vh; min-height: 360px; border: 0; display: block; background: #fff; }
        #bootcamp-learn .bl-field { width: 100%; border: 1.5px solid var(--rd-border); border-radius: 12px; padding: 11px 14px; font-size: 0.9rem; outline: none; background: #fff; margin-top: 8px; }
        #bootcamp-learn .bl-field:focus { border-color: var(--rd-primary); }
        #bootcamp-learn .bl-star { font-size: 1.6rem; cursor: pointer; color: #d8dee6; }
        #bootcamp-learn .bl-star.on { color: #f5a623; }
        #bootcamp-learn .bl-res-head { cursor: pointer; }
        #bootcamp-learn .bl-modal-overlay { position: fixed; inset: 0; z-index: 1050; background: rgba(15,23,42,0.55); display: flex; align-items: center; justify-content: center; padding: 20px; }
        #bootcamp-learn .bl-modal-sheet { width: 100%; max-width: 480px; max-height: 85vh; overflow-y: auto; background: #fff; border-radius: 20px; padding: 18px 20px 26px; }
        #bootcamp-learn .bl-modal-head { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 14px; }
        #bootcamp-learn .bl-modal-close { border: none; background: none; font-size: 1.6rem; line-height: 1; color: #9aa5b1; cursor: pointer; }
    </style>

    <div id="appCapsule">

    <!-- Header kelas -->
    <div class="bl-block" style="margin-bottom:0">
        <div style="display:flex;align-items:center;gap:10px">
            <button type="button" style="border:none;background:none;font-size:1.3rem;color:var(--rd-text)" @click="$router.navigate('/bootcamp/classes/' + $params.id + '/intro')" aria-label="Kembali ke Intro Bootcamp">&larr;</button>
            <div style="flex:1;min-width:0">
                <div style="font-weight:700;font-size:1.05rem;color:var(--rd-text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis" x-text="data.class?.name || 'Belajar Bootcamp'"></div>
                <div style="font-size:0.8rem;color:var(--rd-text-muted)" x-text="data.syllabus?.name || ''"></div>
            </div>
        </div>
        <div class="bl-progress-track">
            <div class="bl-progress-bar">
                <div class="bl-progress-fill"
                     :style="`width:${data.is_instructor ? 100 : materialOverallPercent()}%`">
                    <span class="bl-progress-label"
                          x-text="data.is_instructor ? 'Instruktur' : materialOverallPercent() + '%'"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab bar -->
    <div class="bl-tabs">
        <button type="button" class="bl-tab" :class="{active: tab==='info'}" @click="tab='info'"><i class="bi bi-megaphone"></i> Info</button>
        <button type="button" class="bl-tab" :class="{active: tab==='materi'}" @click="tab='materi'"><i class="bi bi-collection"></i> Materi</button>
        <button type="button" class="bl-tab" :class="{active: tab==='member'}" @click="tab='member'"><i class="bi bi-people"></i> Member</button>
        <button type="button" class="bl-tab" :class="{active: tab==='sertifikat'}" @click="tab='sertifikat'"><i class="bi bi-award"></i> Sertifikat</button>
    </div>

    <!-- Loading -->
    <div x-show="ui.loading && !data.class" class="bl-block" style="text-align:center;padding:60px 0;color:var(--rd-text-muted)">
        <div class="spinner-border" role="status"></div>
        <div style="margin-top:10px;font-size:0.9rem">Memuat kelas...</div>
    </div>

    <!-- ==================== TAB INFO ==================== -->
    <template x-if="data.class && tab==='info'">
        <div class="bl-block">
            <!-- Grup WhatsApp -->
            <div class="bl-card" x-show="data.class.whatsapp_group_url">
                <div style="display:flex;align-items:center;gap:12px">
                    <div style="width:44px;height:44px;border-radius:12px;background:#e6f7ec;color:#1a7f4b;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex:none"><i class="bi bi-whatsapp"></i></div>
                    <div style="flex:1">
                        <div style="font-weight:700;color:var(--rd-text)">Grup WhatsApp Kelas</div>
                        <div style="font-size:0.82rem;color:var(--rd-text-muted)">Diskusi, pengumuman, dan tanya jawab.</div>
                    </div>
                    <a :href="data.class.whatsapp_group_url" target="_blank" rel="noopener" class="bl-btn primary">Gabung</a>
                </div>
            </div>

            <!-- Feed -->
            <template x-for="feed in data.feeds" :key="feed.id">
                <div class="bl-card">
                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px">
                        <span class="bl-pin" x-show="feed.pinned">PINNED</span>
                        <span style="font-size:0.78rem;color:var(--rd-text-muted)" x-text="$heroicHelper.formatDate(feed.created_at)"></span>
                    </div>
                    <div class="bl-feed-title" x-show="feed.title" x-text="feed.title"></div>
                    <div class="bl-feed-body" x-text="feed.body"></div>
                </div>
            </template>
            <div class="bl-card" x-show="data.feeds && data.feeds.length === 0" style="text-align:center;color:var(--rd-text-muted)">
                Belum ada pengumuman kelas.
            </div>
        </div>
    </template>

    <!-- ==================== TAB MATERI ==================== -->
    <template x-if="data.class && tab==='materi'">
        <div class="bl-block">
            <template x-for="cm in data.materials" :key="cm.id">
                <div class="bl-material" :class="{locked: cm.is_open != 1}">
                    <div class="bl-material-head" @click="toggleMaterial(cm.id)">
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:700;color:var(--rd-text)" x-text="cm.material_title"></div>
                            <div style="font-size:0.8rem;color:var(--rd-text-muted)" x-text="`${cm.completed_count}/${cm.required_count} tugas selesai`"></div>
                        </div>
                        <span class="bl-badge" :class="cm.progress_percent===100 ? 'done' : 'ongoing'" x-text="cm.is_open ? (cm.progress_percent + '%') : 'Terkunci'"></span>
                        <i class="bi" :class="openMaterials[cm.id] ? 'bi-chevron-up' : 'bi-chevron-down'" style="color:var(--rd-text-muted)"></i>
                    </div>

                    <div class="bl-material-body" x-show="openMaterials[cm.id]">
                        <!-- Lock overlay untuk materi belum dibuka -->
                        <template x-if="!cm.is_open">
                            <div class="bl-lock">
                                <div class="bl-lock-box">
                                    <i class="bi bi-lock-fill"></i>
                                    <div class="bl-lock-title">Materi Belum Dibuka</div>
                                    <div class="bl-lock-sub">Menunggu pembukaan dari instruktur.</div>
                                </div>
                            </div>
                        </template>

                        <!-- Deskripsi materi -->
                        <div class="bl-res" x-show="cm.material_description">
                            <div style="font-size:0.88rem;color:var(--rd-text-muted)" x-text="cm.material_description"></div>
                        </div>

                        <!-- Resource: klik untuk dropdown, lalu "Buka Materi" membuka modal -->
                        <template x-for="res in cm.resources" :key="res.id">
                            <div class="bl-res">
                                <div class="bl-res-head" @click="toggleResource(cm.id, res.id)">
                                    <div class="bl-res-icon"><i :class="resIcon(res.type)"></i></div>
                                    <div class="bl-res-title" x-text="res.title"></div>
                                    <span class="bl-badge"
                                          :class="res.progress==='completed' ? 'done' : (res.progress==='in_progress' ? 'ongoing' : 'wait')"
                                          x-text="res.progress==='completed' ? 'Selesai' : (res.progress==='in_progress' ? 'Proses' : 'Belum')"></span>
                                    <i class="bi" :class="openResources[cm.id+'-'+res.id] ? 'bi-chevron-up' : 'bi-chevron-down'" style="color:var(--rd-text-muted)"></i>
                                </div>
                                <!-- Dropdown: tampilkan tombol Buka Materi -->
                                <div class="bl-res-drop" x-show="openResources[cm.id+'-'+res.id]">
                                    <button type="button" class="bl-btn primary bl-open-btn" @click="openResource(cm, res)">
                                        <i class="bi bi-folder2-open"></i> Buka Materi
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <!-- ==================== TAB MEMBER ==================== -->
    <template x-if="data.class && tab==='member'">
        <div class="bl-block">
            <div class="bl-card" x-show="data.members && data.members.length===0" style="text-align:center;color:var(--rd-text-muted)">Belum ada peserta.</div>
            <div class="bl-card" style="padding:6px 14px">
                <template x-for="m in data.members" :key="m.id">
                    <div class="bl-member">
                        <div class="bl-avatar" x-text="(m.user_name||'?').charAt(0).toUpperCase()"></div>
                        <div style="flex:1;min-width:0">
                            <div style="font-weight:600;color:var(--rd-text)" x-text="m.user_name"></div>
                            <div style="font-size:0.8rem;color:var(--rd-text-muted)" x-text="m.role==='instructor' ? 'Instruktur' : 'Peserta'"></div>
                        </div>
                        <span class="bl-badge" :class="m.role==='instructor' ? 'done' : 'wait'" x-text="m.role==='instructor' ? 'Instruktur' : 'Peserta'"></span>
                    </div>
                </template>
            </div>
        </div>
    </template>

    <!-- ==================== TAB SERTIFIKAT ==================== -->
    <template x-if="data.class && tab==='sertifikat'">
        <div class="bl-block">
            <!-- Sudah ada sertifikat -->
            <template x-if="data.certificates && data.certificates.length > 0">
                <div>
                    <template x-for="cert in data.certificates" :key="cert.id">
                        <div class="bl-card" style="text-align:center;padding:20px">
                            <i class="bi bi-award-fill" style="font-size:2.4rem;color:#f5a623"></i>
                            <div style="font-weight:700;font-size:1.05rem;color:var(--rd-text);margin-top:8px">Sertifikat Kelulusan</div>
                            <div style="font-size:0.85rem;color:var(--rd-text-muted)" x-text="cert.participant_name"></div>
                            <div style="font-size:0.85rem;color:var(--rd-text-muted)" x-text="cert.title"></div>
                            <a :href="'/certificate/' + cert.cert_code" target="_blank" class="bl-btn primary" style="margin-top:14px;display:inline-flex;align-items:center;gap:6px">
                                <i class="bi bi-eye"></i> Lihat Sertifikat
                            </a>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Blok klaim -->
            <template x-if="!(data.certificates && data.certificates.length > 0)">
                <div>
                <div class="bl-card">
                    <div style="font-weight:700;color:var(--rd-text);margin-bottom:10px">Klaim Sertifikat</div>

                    <!-- Checklist requirement -->
                    <template x-if="data.can_claim && data.can_claim.requirements && data.can_claim.requirements.length > 0">
                        <div style="margin-bottom:12px">
                            <div style="font-size:0.85rem;color:var(--rd-text-muted);margin-bottom:6px">Syarat tugas wajib:</div>
                            <template x-for="req in data.can_claim.requirements" :key="req.resource_id">
                                <div style="display:flex;align-items:center;gap:8px;padding:6px 0">
                                    <i class="bi" :class="req.done ? 'bi-check-circle-fill' : 'bi-circle'" :style="req.done ? 'color:#1a7f4b' : 'color:#c3ccd6'"></i>
                                    <span style="font-size:0.9rem;color:var(--rd-text)" x-text="req.title"></span>
                                </div>
                            </template>
                        </div>
                    </template>

                    <template x-if="data.feedback && data.feedback.rating">
                        <div style="padding:10px;border-radius:12px;background:#e6f6ec;color:#1a7f4b;font-size:0.88rem;margin-bottom:12px">
                            <i class="bi bi-check-circle-fill"></i> Feedback sudah diisi.
                        </div>
                    </template>

                    <div x-show="data.can_claim && !data.can_claim.allowed" style="padding:10px;border-radius:12px;background:#f3f4f6;color:#6b7280;font-size:0.88rem;margin-bottom:12px">
                        <i class="bi bi-info-circle"></i> <span x-text="data.can_claim.reason"></span>
                    </div>

                    <button type="button" class="bl-btn primary" style="width:100%"
                            :disabled="!data.can_claim.allowed || claiming"
                            @click="claimCertificate()">
                        <span x-show="claiming" class="spinner-border spinner-border-sm" role="status"></span>
                        <span x-show="!claiming"><i class="bi bi-award"></i> Klaim Sertifikat</span>
                    </button>
                </div>

                <!-- Feedback -->
                <div class="bl-card" x-show="!data.feedback">
                    <div style="font-weight:700;color:var(--rd-text);margin-bottom:4px">Feedback Kelas</div>
                    <p style="font-size:0.85rem;color:var(--rd-text-muted);margin:0 0 10px">Isi feedback untuk membantuk kami meningkatkan kualitas kelas. Wajib sebelum klaim sertifikat.</p>
                    <template x-for="f in feedbackFields" :key="f.key">
                        <div style="margin-bottom:10px">
                            <label style="font-size:0.82rem;color:var(--rd-text-muted)" x-text="f.label"></label>
                            <template x-if="f.key==='rating'">
                                <div style="display:flex;gap:6px;margin-top:6px">
                                    <template x-for="n in [1,2,3,4,5]" :key="n">
                                        <span class="bl-star" :class="feedback.rating>=n ? 'on' : ''" @click="feedback.rating=n">&#9733;</span>
                                    </template>
                                </div>
                            </template>
                            <template x-if="f.key==='condition_before'">
                                <select class="bl-field" x-model="feedback.condition_before">
                                    <option value="">Pilih kondisi sebelum bootcamp</option>
                                    <option value="a">Belum pernah ngoding</option>
                                    <option value="b">Pernah coba, tapi berhenti</option>
                                    <option value="c">Bisa dasar HTML/CSS</option>
                                    <option value="d">Bisa front-end, ingin back-end</option>
                                    <option value="e">Bekerja di bidang IT, ingin upgrade</option>
                                    <option value="f">Lainnya</option>
                                </select>
                            </template>
                            <template x-if="f.key==='condition_before_other' && feedback.condition_before==='f'">
                                <input type="text" class="bl-field" x-model="feedback.condition_before_other" placeholder="Jelaskan...">
                            </template>
                            <template x-if="f.key==='allow_testimonial'">
                                <label style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:var(--rd-text)">
                                    <input type="checkbox" x-model="feedback.allow_testimonial"> Izinkan testimoni saya ditampilkan
                                </label>
                            </template>
                            <template x-if="!['rating','condition_before','condition_before_other','allow_testimonial'].includes(f.key)">
                                <textarea class="bl-field" x-model="feedback[f.key]" rows="2" :placeholder="f.placeholder || ''"></textarea>
                            </template>
                        </div>
                    </template>
                    <button type="button" class="bl-btn primary" style="width:100%" :disabled="feedbackSubmitting" @click="sendFeedback()">
                        <span x-show="feedbackSubmitting" class="spinner-border spinner-border-sm" role="status"></span>
                        <span x-show="!feedbackSubmitting"><i class="bi bi-send"></i> Kirim Feedback</span>
                    </button>
                </div>
                </div>
            </template>
        </div>
    </template>

    </div>

    <!-- ==================== MODAL RESOURCE ==================== -->
    <div class="bl-modal-overlay" x-show="modalOpen" x-cloak x-transition.opacity @keydown.escape.window="closeResource()" @click.self="closeResource()">
        <div class="bl-modal-sheet" @click.stop>
            <div class="bl-modal-head">
                <div style="display:flex;align-items:center;gap:10px">
                    <div class="bl-res-icon"><i :class="activeResource ? resIcon(activeResource.type) : ''"></i></div>
                    <div style="min-width:0">
                        <div style="font-weight:700;color:#1c2733;font-size:1rem;word-break:break-word" x-text="activeResource?.title"></div>
                        <div style="font-size:0.8rem;color:var(--rd-text-muted)" x-text="activeResource ? typeLabel(activeResource.type) : ''"></div>
                    </div>
                </div>
                <button type="button" class="bl-modal-close" @click="closeResource()">&times;</button>
            </div>

            <div class="bl-modal-body">
                <!-- TEXT -->
                <template x-if="activeResource && activeResource.type==='text'">
                    <div>
                        <div class="bl-content" x-html="activeResource.content.html || ''"></div>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:10px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- VIDEO -->
                <template x-if="activeResource && activeResource.type==='video'">
                    <div>
                        <div class="bl-video-wrap mb-3" x-show="activeResource.content.url">
                            <iframe :src="videoEmbedUrl(activeResource)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <a x-show="activeResource.content.url" :href="activeResource.content.url" target="_blank" rel="noopener" class="bl-btn outline" style="margin-top:10px;display:inline-flex;align-items:center;gap:6px"><i class="bi bi-box-arrow-up-right"></i> Buka Video</a>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- PDF -->
                <template x-if="activeResource && activeResource.type==='pdf'">
                    <div>
                        <div class="bl-pdf-wrap" x-show="activeResource.content.file_path">
                            <iframe :src="pdfUrl(activeResource.content.file_path)" title="Preview PDF" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-top:12px;flex-wrap:wrap">
                            <a x-show="activeResource.content.file_path" :href="pdfUrl(activeResource.content.file_path)" target="_blank" rel="noopener" class="bl-btn primary" style="display:inline-flex;align-items:center;gap:6px"><i class="bi bi-file-earmark-pdf"></i> Buka PDF Baru</a>
                        </div>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- SLIDE -->
                <template x-if="activeResource && activeResource.type==='slide'">
                    <div>
                        <div class="bl-video-wrap" x-show="activeResource.content.embed_url">
                            <iframe :src="activeResource.content.embed_url" frameborder="0" allowfullscreen></iframe>
                        </div>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- AUDIO -->
                <template x-if="activeResource && activeResource.type==='audio'">
                    <div>
                        <audio controls style="width:100%;margin-top:6px" :src="'/' + (activeResource.content.file_path || '')"></audio>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- URL -->
                <template x-if="activeResource && activeResource.type==='url'">
                    <div>
                        <a :href="activeResource.content.url" target="_blank" rel="noopener" class="bl-btn primary" style="display:inline-flex;align-items:center;gap:6px"><i class="bi bi-box-arrow-up-right"></i> Buka Tautan</a>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- BOOK REF -->
                <template x-if="activeResource && activeResource.type==='book_ref'">
                    <div style="padding:12px;border:1px solid var(--rd-border);border-radius:12px;background:#fff">
                        <div style="font-weight:700;color:var(--rd-text)" x-text="activeResource.content.book_title"></div>
                        <div style="font-size:0.85rem;color:var(--rd-text-muted)" x-text="activeResource.content.author"></div>
                        <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap">
                            <span class="bl-badge wait" x-show="activeResource.content.chapter" x-text="'Bab ' + activeResource.content.chapter"></span>
                            <span class="bl-badge wait" x-show="activeResource.content.page_start" x-text="'Hal ' + activeResource.content.page_start + (activeResource.content.page_end ? '–' + activeResource.content.page_end : '')"></span>
                            <span class="bl-badge wait" x-show="activeResource.content.isbn" x-text="'ISBN ' + activeResource.content.isbn"></span>
                        </div>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- MEETING -->
                <template x-if="activeResource && activeResource.type==='meeting'">
                    <div style="padding:12px;border:1px solid var(--rd-border);border-radius:12px;background:#fff">
                        <div style="font-weight:700;color:var(--rd-text)" x-text="activeResource.title"></div>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:6px" x-show="activeResource.content.description" x-text="activeResource.content.description"></p>
                        <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap">
                            <span class="bl-badge wait" x-show="activeResource.content.duration" x-text="activeResource.content.duration + ' menit'"></span>
                            <span class="bl-badge wait" x-show="activeResource.content.mode" x-text="'Mode: ' + activeResource.content.mode"></span>
                        </div>
                        <p style="font-size:0.85rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                    </div>
                </template>

                <!-- QUIZ (belum tersedia) -->
                <template x-if="activeResource && activeResource.type==='quiz'">
                    <div style="padding:12px;border:1px solid var(--rd-border);border-radius:12px;background:#fff;text-align:center">
                        <i class="bi bi-patch-question" style="font-size:1.6rem;color:var(--rd-text-muted)"></i>
                        <div style="font-weight:700;color:var(--rd-text);margin-top:6px">Kuis Evaluasi</div>
                        <p style="font-size:0.82rem;color:var(--rd-text-muted);margin:4px 0 10px">Kuis akan segera hadir.</p>
                        <button type="button" class="bl-btn outline" disabled>Kerjakan Kuis — Segera Hadir</button>
                    </div>
                </template>

                <!-- SUBMISSION -->
                <template x-if="activeResource && activeResource.type==='submission'">
                    <div>
                        <template x-if="activeResource.submission && activeResource.submission.status==='accepted'">
                            <div style="padding:12px;border-radius:12px;background:#e6f6ec;color:#1a7f4b;font-size:0.88rem">
                                <i class="bi bi-check-circle-fill"></i> Tugas diterima. Nilai: <span x-text="activeResource.submission.review_score"></span>
                            </div>
                        </template>
                        <template x-if="activeResource.submission && activeResource.submission.status==='submitted'">
                            <div style="padding:12px;border-radius:12px;background:#eef4fb;color:#2563eb;font-size:0.88rem">
                                <i class="bi bi-hourglass-split"></i> Tugas menunggu review instruktur.
                            </div>
                        </template>
                        <template x-if="activeResource.submission && activeResource.submission.status==='revision_needed'">
                            <div style="padding:12px;border-radius:12px;background:#fff6e6;color:#b26a00;font-size:0.88rem;margin-bottom:10px">
                                <i class="bi bi-arrow-repeat"></i> Tugas perlu revisi. <span x-show="activeResource.submission.review_note" x-text="'Catatan: ' + activeResource.submission.review_note"></span>
                            </div>
                        </template>

                        <!-- Form submission -->
                        <template x-if="!activeResource.submission || activeResource.submission.status!=='accepted'">
                            <div>
                                <div x-show="(activeResource.content.submission_type || 'upload') === 'upload'">
                                    <input type="file" class="bl-field" :id="'sub-file-'+activeResource.id"
                                           @change="submitFiles[activeResource.id] = $event.target.files[0]">
                                </div>
                                <div x-show="(activeResource.content.submission_type || 'upload') === 'url'">
                                    <input type="url" class="bl-field" :id="'sub-url-'+activeResource.id"
                                           placeholder="https://..." x-model="submitUrls[activeResource.id]">
                                </div>
                                <button type="button" class="bl-btn primary" style="margin-top:10px;width:100%"
                                        :disabled="isSubmitSubmitting(activeResource.id)"
                                        @click="submitFromModal()">
                                    <span x-show="isSubmitSubmitting(activeResource.id)" class="spinner-border spinner-border-sm" role="status"></span>
                                    <span x-show="!isSubmitSubmitting(activeResource.id)"><i class="bi bi-send"></i> Kumpulkan Tugas</span>
                                </button>
                                <p style="font-size:0.82rem;color:var(--rd-text-muted);margin-top:8px" x-show="activeResource.content.instructions" x-text="activeResource.content.instructions"></p>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Tombol Saya Sudah Paham -->
                <button type="button"
                        x-show="activeResource && isViewType(activeResource.type) && activeResource.progress !== 'completed' && activeCm && activeCm.is_open == 1"
                        class="bl-btn primary" style="margin-top:14px;width:100%"
                        :disabled="activeResource ? isSubmitting(activeCm.id, activeResource.id) : true"
                        @click="markProgressFromModal()">
                    <span x-show="activeResource && isSubmitting(activeCm.id, activeResource.id)" class="spinner-border spinner-border-sm" role="status"></span>
                    <span x-show="!activeResource || !isSubmitting(activeCm.id, activeResource.id)"><i class="bi bi-check2-circle"></i> Saya Sudah Paham</span>
                </button>
            </div>
        </div>
    </div>

    <?= $this->include('_bottommenu') ?>
</div>

<?= $this->include('bootcamp/learn/script') ?>
