import api from './axios';

export const getMedicines = async () => {
    const response = await api.get('/medicines');

    return response.data;
};

export const getMedicine = async (id) => {
    const response = await api.get(`/medicines/${id}`);

    return response.data;
};