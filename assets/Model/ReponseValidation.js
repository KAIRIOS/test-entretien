/** @typedef {object} CreerReponseValidation
 * @property {number[]} idReponses
 * @property {string} description
 */

/**
 * @return CreerReponseValidation
 */
export function creerReponseValidation() {
    return {
        idReponses: [],
        description: '',
    }
}