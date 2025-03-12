<div id="router" class="page-content">
    <!-- Beranda -->
    <template
        x-route="/"
        x-template="['/home/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Intro -->
    <template
        x-route="/intro"
        x-template="['/intro/content']"></template>

    <!-- Login -->
    <template
        x-route="/masuk"
        x-template="['/masuk/content']"></template>

    <!-- Aktivasi -->
    <template
        x-route="/aktivasi"
        x-template="['/aktivasi/content']"></template>

    <!-- Register -->
    <template
        x-route="/registrasi"
        x-template="['/registrasi/content']"></template>

    <!-- Confirm Register -->
    <template
        x-route="/registrasi/confirm"
        x-template="['/registrasi/confirm/content']"></template>

    <!-- Reset Password -->
    <template
        x-route="/reset_password"
        x-template="['/reset_password/content']"></template>

    <!-- Change Password -->
    <template
        x-route="/reset_password/change/:token"
        x-template="['/reset_password/change/content']"></template>

    <!-- Page -->
    <template
        x-route="/page/:slug"
        x-template="['/page/content', '/_components/bottommenu']"></template>

    <!-- Courses -->
    <template
        x-route="/courses"
        x-template="['/courses/content', '/_components/bottommenu']"></template>

    <!-- Course Live Session -->
    <template
        x-route="/courses/intro/:slug/live_session"
        x-template="['/courses/intro/live_session/content', '/_components/bottommenu']"></template>
        
    <!-- Course Live Session Detail -->
    <template
        x-route="/courses/intro/:slug/live_session/:id"
        x-template="['/courses/intro/live_session/detail/content', '/_components/bottommenu']"></template>

    <!-- Course Student -->
    <template
        x-route="/courses/intro/:slug/student"
        x-template="['/courses/intro/student/content', '/_components/bottommenu']"></template>

    <!-- Course Detail Student -->
    <template
        x-route="/courses/intro/:slug/student/:id"
        x-template="['/courses/intro/student/detail/content', '/_components/bottommenu']"></template>

    <!-- Course Tanya Jawab -->
    <template
        x-route="/courses/intro/:slug/tanya_jawab"
        x-template="['/courses/intro/tanya_jawab/content', '/_components/bottommenu']"></template>

    <!-- Live Session -->
    <template
        x-route="/courses/intro/:id/:slug"
        x-template="['/courses/intro/content', '/_components/bottommenu']"></template>

    <!-- Lessons -->
    <template
        x-route="/courses/lessons/:slug"
        x-template="['/courses/lessons/content', '/_components/bottommenu']"></template>

    <!-- Courses -->
    <template
        x-route="/courses/quiz/:id"
        x-template="['/courses/quiz/content', '/_components/bottommenu']"></template>

    <!-- Pustaka -->
    <template
        x-route="/pustaka"
        x-template="['/pustaka/content', '/_components/bottommenu']"></template>

    <!-- Tanya Jawab -->
    <template
        x-route="/courses/tanya_jawab"
        x-template="['/courses/tanya_jawab/content', '/_components/bottommenu']"></template>

    <!-- Detail Tanya Jawab -->
    <template
        x-route="/courses/tanya_jawab/detail/:id"
        x-template="['/courses/tanya_jawab/detail/content', '/_components/bottommenu']"></template>

    <!-- Feeds -->
    <template
        x-route="/feeds"
        x-template="['/feeds/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Detail feed -->
    <template
        x-route="/feeds/:id"
        x-template="['/feeds/detail/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Iuran -->
    <template
        x-route="/iuran"
        x-template="['/iuran/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Detail video -->
    <template
        x-route="/checkout/:token?"
        x-template="['/checkout/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Videos -->
    <template
        x-route="/kajian"
        x-template="['/kajian/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Detail video -->
    <template
        x-route="/kajian/:id"
        x-template="['/kajian/detail/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Anggota -->
    <template
        x-route="/anggota"
        x-template="['/anggota/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Detail Anggota -->
    <template
        x-route="/anggota/:id"
        x-template="['/anggota/detail/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Profile -->
    <template
        x-route="/profile"
        x-template="['/profile/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Profile Delete -->
    <template
        x-route="/profile/delete"
        x-template="['/profile/delete/content', '/_components/bottommenu']"
        x-handler="[isLoggedIn]"></template>

    <!-- Profile Edit Info -->
    <template
        x-route="/profile/edit_info"
        x-template="['/profile/edit_info/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Profile Edit Akun -->
    <template
        x-route="/profile/edit_account"
        x-template="['/profile/edit_account/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- Program Pesantren -->
    <template
        x-route="/program_pesantren"
        x-template="['/program_pesantren/content', '/_components/bottommenu']"
        x-handler="isLoggedIn"></template>

    <!-- 404 Page Not Found -->
    <template
        x-route="notfound"
        x-template="/notfound/content"></template>

    <!-- Admin List Tagihan -->
    <template
        x-route="admin/list_tagihan"
        x-template="['/admin/list_tagihan/content', '/_components/bottommenu']"></template>
    <!-- Admin Generate List Tagihan -->
    <template
        x-route="admin/list_tagihan/generate"
        x-template="['/admin/list_tagihan/generate/content', '/_components/bottommenu']"></template>


</div>