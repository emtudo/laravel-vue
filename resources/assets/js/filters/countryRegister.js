// dependencies.
import { toString } from 'lodash'
import { CPF, CNPJ } from 'cpf_cnpj'

// Format document to person
const person = document => CPF.format(document)

// Format documento to company
const company = document => CNPJ.format(document)

// strip special chars.
const strip = document => CNPJ.strip(document)

/**
 * Returns a formatted version a country register document. (CPF / CNPJ).
 *
 * Format document
 **/
export default (original) => {
  // bypass formatting if no value was passed.
  if (original === null) { return original }

  // get digits only.
  const document = strip(toString(original))

  // returns a formatted version of the document.
  return document.length > 11 ? company(document) : person(document)
}
