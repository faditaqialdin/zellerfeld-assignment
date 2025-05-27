export default {
    getAccessToken() {
        return localStorage.getItem('access_token');
    },
    setAccessToken(token) {
        return localStorage.setItem('access_token', token);
    },
    getProfile() {
        return JSON.parse(localStorage.getItem('profile'));
    },
    setProfile(profile) {
        return localStorage.setItem('profile', JSON.stringify(profile));
    },
    clear() {
        localStorage.removeItem('access_token');
        localStorage.removeItem('profile');
    },
};
