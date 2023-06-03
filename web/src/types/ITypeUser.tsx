interface ITypeUser {
  uid: string
  dn: string
  cn?: string
  sn?: string
  mail?: string
  memberOf?: string[]
}

export default ITypeUser
