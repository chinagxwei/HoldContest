import {Paginate, ServerResponse} from './server-response';

describe('ServerResponse', () => {
  it('should create an instance', () => {
    expect(new ServerResponse()).toBeTruthy();
  });
});

describe('Paginate', () => {
  it('should create an instance', () => {
    expect(new Paginate()).toBeTruthy();
  });
});
