export const WAITING = 'waiting';
export const VALIDATED = 'validated';

export const getAll = () => {
    return [WAITING, VALIDATED];
};

export const getLabel = (status) => {
    switch (status) {
        case WAITING:
            return 'En attente';
        case VALIDATED:
            return 'Validée ✅';
        default:
            return '';
    }
};
