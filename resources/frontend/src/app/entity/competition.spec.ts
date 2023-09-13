import {CompetitionGame, CompetitionGameTeam, CompetitionRoom} from './competition';

describe('CompetitionGame', () => {
  it('should create an instance', () => {
    expect(new CompetitionGame()).toBeTruthy();
  });
});

describe('CompetitionGameTeam', () => {
  it('should create an instance', () => {
    expect(new CompetitionGameTeam()).toBeTruthy();
  });
});

describe('CompetitionRoom', () => {
  it('should create an instance', () => {
    expect(new CompetitionRoom()).toBeTruthy();
  });
});
