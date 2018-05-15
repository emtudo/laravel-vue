/**
 * Text matching helpers.
 * @param term
 */

import { method, some, isEmpty } from 'lodash'

/**
 * Generic text match. Case Insensitive.
 *
 * @param {String} term
 */
export const match = term => method('match', new RegExp(term, 'i'))

/**
 * Generic match. Case Sensitive.
 *
 * @param {String} term
 */
export const sensitiveMatch = term => method('match', new RegExp(term))

/**
 * Return true is a a term is match against any of an array of Strings.
 *
 * @param {Array}  ofThose
 * @param {String} thisTerm
 */
export const matchesAny = (ofThose, thisTerm) => isEmpty(thisTerm) ? true : some(ofThose, match(thisTerm))

/**
 * Case sensitive - Return true is a a term is match against any of an array of Strings.
 *
 * @param {Array}  ofThose
 * @param {String} thisTerm
 */
export const sensitiveMatchesAny = (ofThose, thisTerm) => isEmpty(thisTerm) ? true : some(ofThose, sensitiveMatch(thisTerm))
