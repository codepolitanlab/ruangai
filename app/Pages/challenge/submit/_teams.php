<!-- <div class="card rounded-4 mb-3">
    <div class="card-body">
        <div>
            <h5>Team Members <small class="text-muted">(max 3)</small></h5>

            <template x-for="(member, index) in teamMembers" :key="index">
                <div class="card mb-2 shadow-none border rounded-4 bg-success bg-opacity-10">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <strong x-text="'Member ' + (index + 1)"></strong>
                            <button type="button" class="btn btn-sm btn-link text-danger"
                                @click="removeMember(index)"
                                x-show="index > 0">
                                <i class="bi bi-trash me-0"></i>
                            </button>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control mb-2"
                                x-model="member.name"
                                placeholder="Nama Lengkap *">
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control mb-2"
                                x-model="member.email"
                                placeholder="Email *">
                        </div>

                        <div class="form-group">
                            <select class="form-control" x-model="member.role">
                                <option value="leader">Leader</option>
                                <option value="member">Member</option>
                            </select>
                        </div>
                    </div>
                </div>
            </template>

            <button type="button" class="btn btn-outline-primary mt-3"
                @click="addMember()"
                x-show="teamMembers.length < 3">
                <i class="bi bi-person-plus"></i> Tambah Anggota Tim
            </button>

            <template x-if="errors.team_members">
                <div class="alert alert-danger" x-text="errors.team_members"></div>
            </template>

        </div>
    </div>
</div> -->