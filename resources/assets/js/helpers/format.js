const isInvalidItem = (item) => {
  if (typeof (item) === 'undefined' || typeof (item.min) === 'undefined' || typeof (item.max) === 'undefined') {
    return true
  }

  return false
}

export const getMask = (mask, data) => {
  if (!Array.isArray(mask)) {
    return mask
  }

  if (typeof (data) === 'undefined' || data === null) {
    return mask[0].mask
  }

  return mask.reduce((standard, item) => {
    if (isInvalidItem(item)) {
      return standard
    }

    if (data.length >= item.min && data.length <= item.max) {
      return item.mask
    }

    return standard
  }, mask[0].mask)
}

export const format = (data, mask) => {
  if (data === null) {
    return data
  }

  /**
   * Simple format function borrowed from vue-mask
   * {@link https://github.com/probil/v-mask/blob/master/src/format.js}
   *
   * @param {String} data String to mask (input value)
   * @param {String|Array} [mask] Mask format, like `####-##` or [{mask: '####-##'}, {min: 1, max: 5, mask: '#####'}]
   * @returns {string} Formatted text
   */

  // don't do anything if mask is undefined/null/etc
  if (!mask) {
    return data
  }
  mask = getMask(mask, data)

  const maskStartRegExp = /^([^#ANX]+)/

  if (data.length === 1 && maskStartRegExp.test(mask)) {
    data = maskStartRegExp.exec(mask)[0] + data
  }

  let text = ''
  for (let i = 0, x = 1; x && i < mask.length; ++i) {
    let c = data.charAt(i)
    let m = mask.charAt(i)

    switch (m) {
      case '#' : if (/\d/.test(c)) { text += c } else { x = 0 } break
      case 'A' : if (/[a-z]/i.test(c)) { text += c } else { x = 0 } break
      case 'N' : if (/[a-z0-9]/i.test(c)) { text += c } else { x = 0 } break
      case 'X' : text += c; break
      default :
        if (i < data.length) {
          text += m
        }

        // preserve characters that are in the same spot we need to insert a mask
        // character by shifting the data over to the right (issue #5, & #7)
        if (c && c !== m) {
          data = ' ' + data
        }

        break
    }
  }

  return text
}
