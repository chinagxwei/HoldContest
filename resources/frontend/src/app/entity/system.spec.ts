import {Navigation, Role, SystemAgreement, SystemComplaint, SystemConfig, Target, Unit} from "./system";


describe('SystemAgreement', () => {
  it('should create an instance', () => {
    expect(new SystemAgreement()).toBeTruthy();
  });
});

describe('SystemComplaint', () => {
  it('should create an instance', () => {
    expect(new SystemComplaint()).toBeTruthy();
  });
});

describe('SystemConfig', () => {
  it('should create an instance', () => {
    expect(new SystemConfig()).toBeTruthy();
  });
});

describe('Navigation', () => {
  it('should create an instance', () => {
    expect(new Navigation()).toBeTruthy();
  });
});

describe('Role', () => {
  it('should create an instance', () => {
    expect(new Role()).toBeTruthy();
  });
});

describe('Target', () => {
  it('should create an instance', () => {
    expect(new Target()).toBeTruthy();
  });
});

describe('Image', () => {
  it('should create an instance', () => {
    expect(new Image()).toBeTruthy();
  });
});

describe('Unit', () => {
  it('should create an instance', () => {
    expect(new Unit()).toBeTruthy();
  });
});
