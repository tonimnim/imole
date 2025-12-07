import { createApp } from 'vue';
import StudentHome from './components/student/StudentHome.vue';

const el = document.getElementById('student-home');
if (el) {
    const app = createApp(StudentHome, {
        userName: el.dataset.userName || 'Student'
    });
    app.mount('#student-home');
}
