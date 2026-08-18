import api from './axios';


// get  medicines (show all medicine)
export const getMedicines = async () => {

    const response = await api.get('/medicines');

    console.log('MEDICINES API:', response.data);

    return response.data.data?.data ?? [];
};


// get evry medicine by id 
export const getMedicine = async (id) => {

    const response = await api.get(`/medicines/${id}`);

    console.log('MEDICINE API:', response.data);

    return response.data.data ?? response.data;
};